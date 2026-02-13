<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $course= $course;
        $faqs= FAQ::where('courseId', $course->id)->get();
        return view('Teacher.Course.faqs', compact(['course', 'faqs']));
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
    public function store(Request $request, Course $course)
    {
        $validated= $request->validate([
            'question'=>'required|string',
            'answer'=>'required|string',
        ]);

        FAQ::create([
            'courseId'=> $course->id,
            'question'=> $validated['question'],
            'answer'=> $validated['answer'],
        ]);

        return redirect()->back()->with('success', 'FAQ added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQ $fAQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $fAQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, FAQ $faq)
    {
        $validated= $request->validate([
            'question'=>'required|string',
            'answer'=>'required|string',
        ]);
        
        $courseId = $course->id;

        $faq->update([
            'question'=> $validated['question'],
            'answer'=> $validated['answer'],
        ]);
        return redirect()->back()->with('success', 'faq updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course ,FAQ $faq)
    {
        $faq->delete();
        return redirect()->back()->with('success', 'FAQ deleted successfully');
    }
}
