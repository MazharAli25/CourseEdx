<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Pricing;
use App\Traits\CourseBuilderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    use CourseBuilderTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teacherId= Auth::id();
        if ($request->ajax()) {
            $courses = Course::where('teacherId', $teacherId);

            return DataTables::eloquent($courses)
                ->editColumn('image', function ($course) {
                    return '
                    <img src="'.asset($course->thumbnail).'" width="70px" height="70px"></img>
                    ';
                })
                ->editColumn('actions', function ($course) {
                    return '
                        <a href="'.route('courses.basic', $course->id).'" class="btn btn-sm btn-primary">Edit</a>
                    ';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }

        return view('Teacher.Course.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Categories::get();

        return view('Teacher.Course.create', compact(['cats']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'categoryId' => 'required|exists:categories,id',
            'subcategoryId' => 'required|exists:sub_categories,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $imageName = time().'_'.$thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/thumbnails'), $imageName);
            $validated['thumbnail'] = 'uploads/thumbnails/'.$imageName;
        }

        $validated['teacherId'] = Auth::id();
        $validated['slug'] = Str::slug($validated['slug']);

        Course::create([
            'teacherId' => $validated['teacherId'],
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'level' => $validated['level'],
            'language' => $validated['language'],
            'description' => $validated['description'],
            'thumbnail' => $validated['thumbnail'],
            'categoryId' => $validated['categoryId'],
            'subcategoryId' => $validated['subcategoryId'],
        ]);

        return redirect()
            ->route('course.index')
            ->with('success', 'Course Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // allow null
            'categoryId' => 'required|exists:categories,id',
            'subcategoryId' => 'required|exists:sub_categories,id',
        ]);

        // Handle thumbnail if uploaded
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $imageName = time().'_'.$thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/thumbnails'), $imageName);
            $course->thumbnail = 'uploads/thumbnails/'.$imageName;
        }

        // Update other fields
        $course->title = $validated['title'];
        $course->slug = $validated['slug'];
        $course->description = $validated['description'];
        $course->categoryId = $validated['categoryId'];
        $course->subcategoryId = $validated['subcategoryId'];
        $course->teacherId = Auth::id();

        $course->save();

        return redirect()->route('courses.basic', $course->id)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }

    public function basicInfo(Course $course)
    {
        $cats = Categories::with('subcats')->get();

        return view('teacher.course.basic', compact('course', 'cats'));
    }

    public function requirements(Course $course)
    {
        $course = $course;

        return view('Teacher.Course.requirements', compact('course'));
    }

    public function publish(Course $course)
    {
        $course->load([
            'sections.lectures',
            'faqs',
        ]);
        $price = Pricing::where('courseId', $course->id)->first();

        return view('Teacher.Course.publish', compact(['course', 'price']));
    }

    public function preview(Course $course)
    {
        // Eager load all relationships
        $course->load([
            'sections.lectures.materials',
            'faqs',
            'category',
            'teacher',
        ]);

        // Calculate totals
        $totalSections = $course->sections->count();
        $totalLectures = $course->sections->sum(function ($section) {
            return $section->lectures->count();
        });

        // Calculate total hours (assuming each lecture is 30 minutes)
        $totalHours = round(($totalLectures * 30) / 60, 1);

        // Count materials
        $totalMaterials = 0;
        foreach ($course->sections as $section) {
            foreach ($section->lectures as $lecture) {
                $totalMaterials += $lecture->materials->count();
            }
        }

        // Get pricing
        $price = Pricing::where('courseId', $course->id)->first();

        // Get instructor stats (you'll need to implement these)
        $totalCourses = Course::where('teacherId', $course->teacherId)->count();
        $totalStudents = 0; // You'll need to implement student enrollment counting

        return view('Teacher.Course.preview', compact(
            'course',
            'price',
            'totalSections',
            'totalLectures',
            'totalHours',
            'totalMaterials',
            'totalCourses',
            'totalStudents'
        ));
    }

    public function pendingStatus(Request $request,Course $course){
        
        $course->update([
            'status'=> 'pending',
        ]);

        return redirect()->back()->with('success', 'Course Status Updated successfully');
    }
}
