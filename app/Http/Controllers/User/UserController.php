<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Course;
use App\Models\CourseLecture;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function viewCourses(Request $request)
    {
        $categories = Categories::all();

        $query = Course::with('category', 'subcategory')
            ->where('status', 'published');

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->category) {
            $query->where('categoryId', $request->category); // FIXED
        }

        if ($request->subcategory) {
            $query->where('subcategoryId', $request->subcategory);
        }

        if ($request->level) {
            $query->where('level', $request->level);
        }

        if ($request->price === 'free') {
            $query->where('price', 0);
        }

        if ($request->price === 'paid') {
            $query->where('price', '>', 0);
        }

        $courses = $query->latest()->paginate(9)->withQueryString();

        return view('User.Courses.index', compact('courses', 'categories'));
    }

    public function courseShow(Course $course)
    {
        $course->load(['category', 'sections.lectures']);
        $totalLectures = CourseLecture::whereHas('section', function ($q) use ($course) {
            $q->where('courseId', $course->id);
        })->count();

        return view('User.Courses.Show', compact(['course', 'totalLectures']));
    }
}
