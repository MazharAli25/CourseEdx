<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LectureMaterial;
use Illuminate\Http\Request;

class LectureMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {

        return view('Teacher.Course.lectureMaterials', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LectureMaterial $lecture)
    {
        $validated = $request->validate([
            'materials' => 'required|array',
            'materials.*.*' => 'file|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx,txt,zip,rar,7z,csv,json,xml,md|max:51200',
        ]);

        $uploadedCount = 0;

        foreach ($validated['materials'] as $lectureId => $files) {
            foreach ($files as $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = 'uploads/lecture_materials/'.$fileName;
                $file->move(public_path('uploads/lecture_materials'), $fileName);
                LectureMaterial::create([
                    'lectureId' => $lectureId,
                    'fileName' => $fileName,
                    'filePath' => $filePath,
                    'fileType' => $file->getClientOriginalExtension(),
                ]);
            }

            $uploadedCount++;
        }

        return redirect()->back()->with('success', $uploadedCount.' materials uploaded Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(LectureMaterial $lectureMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LectureMaterial $lectureMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LectureMaterial $lectureMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LectureMaterial $material)
    {
        
        if (file_exists(public_path($material->filePath))) {
            unlink(public_path($material->filePath));
        }
        
        $material->delete();

        return response()->json(['success' => true, 'message' => 'Material deleted successfully']);
    }
}
