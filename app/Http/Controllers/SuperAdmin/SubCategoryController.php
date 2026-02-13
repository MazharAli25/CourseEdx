<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $subCat= SubCategory::query();
            return DataTables::eloquent($subCat)
            ->editColumn('category', function($subCat){
                return $subCat->category->name;
            })
            ->editColumn('actions', function($subCat){
                return '
                    <a href="'.route('sub-category.edit', $subCat->id).'" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-danger btn-sm delete-user delete-btn" data-id="'.$subCat->id.'" >Delete</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
        }
        return view('SuperAdmin.SubCategory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories= Categories::get();
        return view('SuperAdmin.SubCategory.create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated= $request->validate([
            'categoryId'=>'numeric|required',
            'name'=>'string|required',
            'slug'=>'string|required',
        ]);
        $validated['slug']=Str::slug($validated['slug']);

        SubCategory::create($validated);
        
        return redirect()->route('sub-category.index')->with('success', 'Sub Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        $cats= Categories::get();
        return view('SuperAdmin.subCategory.edit', compact(['cats', 'subCategory']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
         $validated= $request->validate([
            'categoryId'=>'numeric|required',
            'name'=>'string|required',
            'slug'=>'string|required',
        ]);
        $validated['slug']=Str::slug($validated['slug']);

        $subCategory->update($validated);

        return redirect()->route('sub-category.index')->with('success', 'Sub Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return response()->json(['success'=>true, 'message'=>'Sub Category deleted successfully']);
    }
}
