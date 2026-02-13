<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $policies = PrivacyPolicy::query();

            return DataTables::eloquent($policies)
                ->editColumn('title', function ($policy) {
                    return $policy->heading;
                })
                ->editColumn('description', function ($policy) {
                    return Str::limit($policy->body, 70);
                })
                ->editColumn('status', function ($policy) {
                    return '
                    <select class="form-control status-dropdown" data-id="'.$policy->id.'" data-current="'.$policy->status.'">
                        <option value="active" '.($policy->status == 'active' ? 'selected' : '').'>Active</option>
                        <option value="inactive" '.($policy->status == 'inactive' ? 'selected' : '').'>Inactive</option>
                    </select>
                ';
                })
                ->editColumn('actions', function ($policy) {
                    return '
                    <a href="'.route('privacy-policy.edit', $policy->id) .'"  class="btn btn-sm btn-primary"> Edit</a>
                    <button class="btn btn-danger btn-sm delete-user delete-btn" data-id="'.$policy->id.'" >Delete</button>

                ';
                })
                ->rawColumns(['description', 'status', 'actions'])
                ->make(true);

        }

        return view('SuperAdmin.PrivacyPolicy.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SuperAdmin.PrivacyPolicy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.heading' => 'required|string',
            'sections.*.body' => 'required|string',
            'sections.*.type' => 'required|string|in:tc,pp',
        ]);
        foreach ($validated['sections'] as $section) {
            PrivacyPolicy::create([
                'heading' => $section['heading'],
                'body' => $section['body'],
                'type' => $section['type'],
                'status' => isset($section['is_active']) && $section['is_active'] == '1' ? 'active' : 'inactive',
                'updated_at'=> now()
            ]);
        }

        return redirect()->route('privacy-policy.create')->with('success', 'T&C/Privacy Policy sections added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('SuperAdmin.PrivacyPolicy.edit', compact(['privacyPolicy']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $validated= $request->validate([
            'heading'=> 'string|required',
            'body'=> 'string|required',
            'type'=> 'string|in:tc,pp',
        ]);

        $validated['status'] = $request->has('is_active') ? 'active' : 'inactive';

        $privacyPolicy->update($validated);
        return redirect()->route('privacy-policy.index')->with('success', 'Privacy Policy updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();
        return response()->json(['success'=>true, 'message'=>'Privacy Policy deleted successfully']);
    }

    public function updateStatus(Request $request, $id){
        $policy= PrivacyPolicy::find($id);

        if(!$policy){
            return response()->json(['success'=> false, 'message'=>'Privacy Policy not found']);
        }

        $policy->status= $request->input('status');
        $policy->save();

        return response()->json(['success'=> true, 'Status Updated Successfully']);

    }
}
