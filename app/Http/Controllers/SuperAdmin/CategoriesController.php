<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $categories= Categories::query();
            return DataTables::eloquent($categories)
            ->editColumn('actions', function($category){
                return '
                    <a href="'.route('category.edit', $category->id).'" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-danger btn-sm delete-user delete-btn" data-id="'.$category->id.'" >Delete</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
        }
        return view('SuperAdmin.Categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SuperAdmin.Categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated= $request->validate([
            'name'=>'required|string',
            'slug'=>'required|string',
        ]);

        $slug= Str::slug($validated['slug']);

        Categories::create([
            'name'=>$validated['name'],
            'slug'=>$slug,
        ]);

        return redirect()->route('category.index')->with('success', 'Category added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $category)
    {
        return view('SuperAdmin.Categories.edit', compact(['category']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categories $category)
    {
        $validated= $request->validate([
            'name'=>'required|string',
            'slug'=>'required|string',
        ]);

        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        $category= Categories::find($category->id);
        $category->delete();
        return response()->json(['success'=>true, 'message'=>'Category deleted successfully']);
    }
}
