<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Teacher.dashboard');
    }

    public function enrollmentsList(Request $request)
    {
        if ($request->ajax()) {
            $teacher = Auth::user();

            $enrollments = Enrollment::whereHas('course', function ($query) use ($teacher) {
                $query->where('teacherId', $teacher->id);
            })
                ->with(['student', 'course']);

            return DataTables::eloquent($enrollments)
                ->addColumn('image', function ($enrollment) {
                    if (! $enrollment->student || ! $enrollment->student->image) {
                        return '';
                    }

                    return '<img src="'.asset('storage/'.$enrollment->student->image).'" 
                        width="50" 
                        height="50" 
                        class="rounded-circle" />';
                })
                ->addColumn('name', function ($enrollment) {
                    return $enrollment->student->name;
                })
                ->addColumn('email', function ($enrollment) {
                    return $enrollment->student->email;
                })
                ->addColumn('course', function ($enrollment) {
                    return $enrollment->course->title;
                })
                ->addColumn('actions', function ($enrollment) {
                    return '
                        <button class="btn btn-sm btn-primary">View</button>
                    ';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }

        return view('Teacher.Course.enrollments');
    }
}
