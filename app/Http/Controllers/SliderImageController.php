<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;

class SliderImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sliderImages = SliderImage::select('id', 'image', 'title', 'description', 'status');

            return datatables()->of($sliderImages)
                ->addIndexColumn()
                ->editColumn('title', function ($sliderImage) {
                    return $sliderImage->title ?? 'N/A';
                })
                ->editColumn('image', function ($sliderImage) {
                    return '<img src="'.asset($sliderImage->image).'" alt="Slider Image" width="100" height="50"/>';
                })
                ->editColumn('status', function ($sliderImage) {
                    return '
                        <select class="form-control status-dropdown" data-id="'.$sliderImage->id.'"
                            data-id="'.$sliderImage->id.'"
                            data-current="'.$sliderImage->status.'">
                            <option value="active" '.($sliderImage->status == 'active' ? 'selected' : '').'>Active</option>
                            <option value="inactive" '.($sliderImage->status == 'inactive' ? 'selected' : '').'>Inactive</option>
                        </select>
                    ';
                })
                ->addColumn('actions', function ($sliderImage) {
                    $editUrl = route('slider-images.edit', encrypt($sliderImage->id));
                    $deleteUrl = route('slider-images.destroy', encrypt($sliderImage->id));

                    return '<a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.encrypt($sliderImage->id).'">
                                Delete
                            </button>';
                })
                ->rawColumns(['image', 'status', 'actions'])
                ->make(true);
        }

        return view('SuperAdmin.SystemSettings.SliderImages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SuperAdmin.SystemSettings.SliderImages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $sliderImage = $request->file('image');
            $imageName = time().'_'.$sliderImage->getClientOriginalName();
            $sliderImage->move(public_path('uploads/slider/'), $imageName);
        }

        // Create new SliderImage record
        SliderImage::create([
            'image' => 'uploads/slider/'.$imageName,
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('slider-images.index')->with('success', 'Slider image added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SliderImage $sliderImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SliderImage $sliderImage)
    {
        return view('SuperAdmin.SystemSettings.SliderImages.edit', compact('sliderImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SliderImage $sliderImage)
    {
        $validated = $request->validate([
            'title' => 'string|nullable',
            'description' => 'string|nullable',
            'image' => 'image|nullable|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/slider/'), $imageName);

            $validated['image'] = 'uploads/slider/'.$imageName;
        } else {
            // keep the old image
            $validated['image'] = $sliderImage->image;
        }

        $sliderImage->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? $sliderImage->image,
        ]);

        return redirect()->route('slider-images.index')->with('success', 'Slider image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SliderImage $sliderImage)
    {
        $sliderImage->delete();

        return response()->json(['success' => true, 'message' => 'Slider image deleted successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $sliderImage = SliderImage::findOrFail($id);
        $sliderImage->status = $request->input('status');
        $sliderImage->save();

        return response()->json(['success' => true]);
    }
}
