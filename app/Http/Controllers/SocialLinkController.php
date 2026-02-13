<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $socialLinks = SocialLink::select(['id', 'platform', 'url', 'status', 'icon_class', 'created_at', 'updated_at']);

            return datatables()->of($socialLinks)
                ->addColumn('icon', function ($row) {
                    return '<i class="'.$row->icon_class.' fa-2x"></i>';
                })
                ->editColumn('status', function ($link) {
                    return '
                        <select class="form-control status-dropdown" data-id="'.$link->id.'"
                            data-id="'.$link->id.'"
                            data-current="'.$link->status.'">
                            <option value="active" '.($link->status == 'active' ? 'selected' : '').'>Active</option>
                            <option value="inactive" '.($link->status == 'inactive' ? 'selected' : '').'>Inactive</option>
                        </select>
                    ';
                })
                ->addColumn('actions', function ($row) {
                    $editUrl = route('social-links.edit', encrypt($row->id));

                    return '
                         <a href="'.$editUrl.'" class="btn btn-sm btn-primary mr-1">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.encrypt($row->id).'">
                                Delete
                            </button>
                    ';
                })
                ->rawColumns(['icon', 'status', 'actions'])
                ->make(true);
        }

        return view('SuperAdmin.SystemSettings.SocialLinks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SuperAdmin.SystemSettings.SocialLinks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'platform' => 'required|string|max:255|unique:social_links,platform',
            'url' => 'required|url|max:255',
        ]);

        $iconName = strtolower($validated['platform']);
        $icon = 'fab fa-'.$iconName;

        SocialLink::create([
            'platform' => $validated['platform'],
            'url' => $validated['url'],
            'icon_class' => $icon,
        ]);

        return redirect()->route('social-links.index')->with('success', 'Social link created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialLink $socialLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialLink $socialLink)
    {
        return view('SuperAdmin.SystemSettings.SocialLinks.edit', compact('socialLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255|unique:social_links,platform,'.$socialLink->id,
            'url' => 'required|url|max:255',
        ]);

        $iconName = strtolower($validated['platform']);
        $icon = 'fab fa-'.$iconName;

        $socialLink->update([
            'platform' => $validated['platform'],
            'url' => $validated['url'],
            'icon_class' => $icon,
        ]);

        return redirect()->route('social-links.index')->with('success', 'Social link updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return response()->json(['success' => true, 'message' => 'Social link deleted successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $socialLink = SocialLink::findOrFail($id);
        $socialLink->status = $request->input('status');
        $socialLink->save();

        return response()->json(['success' => true]);
    }
}
