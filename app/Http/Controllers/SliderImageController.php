<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;

class SliderImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Handle file upload
        if($request->hasFile('image')){
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SliderImage $sliderImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SliderImage $sliderImage)
    {
        //
    }
}
