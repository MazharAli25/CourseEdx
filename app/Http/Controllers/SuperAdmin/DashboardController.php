<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Pricing;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('SuperAdmin.dashboard');
    }

    public function registeredUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('role', '!=', 'super-admin');

            return DataTables::eloquent($users)
                ->editColumn('image', function ($user) {
                    return '<img src="'.asset($user->image ? $user->image : asset('images/default-avater.jfif')).'" alt="user Image" width="60" height="55" class="rounded-circle"/>';
                })
                ->editColumn('role', function ($user) {
                    return '
                    <select class="form-control role-dropdown" data-id="'.$user->id.'" data-current="'.$user->role.'">
                        <option value="super-admin" '.($user->role == 'super-admin' ? 'selected' : '').'>Super Admin</option>
                        <option value="teacher" '.($user->role == 'teacher' ? 'selected' : '').'>Teacher</option>
                        <option value="student" '.($user->role == 'student' ? 'selected' : '').'>Student</option>
                    </select>
                    ';
                })
                ->editColumn('status', function ($user) {
                    return '
                    <select class="form-control status-dropdown" data-id="'.$user->id.'" data-current="'.$user->status.'">
                        <option value="enabled" '.($user->status == 'enabled' ? 'selected' : '').'>Enabled</option>
                        <option value="disabled" '.($user->status == 'disabled' ? 'selected' : '').'>Disabled</option>
                    </select>
                    ';
                })
                ->editColumn('actions', function ($user) {
                    return '
                        <button class="btn btn-danger btn-sm delete-user delete-btn" data-id="'.$user->id.'" >Delete</button>
                    ';
                })
                ->rawColumns(['image', 'role', 'status', 'actions'])
                ->make(true);
        }

        return view('SuperAdmin.registeredUsers');
    }

    public function updateUserStatus(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'user not found.']);
        }

        $user->status = $request->input('status');
        $user->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'user not found.']);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'user deleted successfully.']);
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'user not found.']);
        }

        $user->role = $request->input('role');
        $user->save();

        return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
    }

    public function coursesRequests(Request $request)
    {
        if ($request->ajax()) {

            $courses = Course::with(['teacher', 'category', 'subcategory'])
                ->where('status', 'pending');

            return DataTables::eloquent($courses)
                ->addColumn('thumbnail', function ($course) {
                    return '<img src="'.asset($course->thumbnail).'" width="90" height="90"  />';
                })
                ->addColumn('teacherName', function ($course) {
                    return $course->teacher->name ?? '';
                })
                ->addColumn('category', function ($course) {
                    return $course->category->name ?? '';
                })
                ->addColumn('sub_category', function ($course) {
                    return $course->subcategory->name ?? '';
                })
                ->addColumn('status', function ($course) {
                    return '
                        <button class="btn btn-sm btn-secondary">
                            '.$course->status.'
                        </button>
                    ';
                })
                ->addColumn('actions', function ($course) {

                    $previewUrl = route('course.preview', $course->id);

                    return '
                        <button class="btn btn-success btn-sm approve-btn" data-id="'.$course->id.'">Approve</button>
                        <button class="btn btn-danger btn-sm reject-btn" data-id="'.$course->id.'">Reject</button>
                        <button class="btn btn-info btn-sm preview-btn" data-id="'.$course->id.'">Preview</button>
                    ';
                })
                ->rawColumns(['thumbnail', 'status', 'actions'])
                ->make(true);
        }

        return view('SuperAdmin.Course.requests');
    }

    public function approveCourse(Course $course)
    {
        $course->update(['status' => 'published']);

        return response()->json([
            'success' => true,
            'message' => 'Course approved successfully',
        ]);
    }

    public function rejectCourse(Request $request, Course $course)
    {
        $request->validate([
            'rejection_title' => 'required|string|max:255',
            'rejection_description' => 'required|string',
        ]);

        $course->update([
            'rejection_title' => $request->rejection_title,
            'rejection_description' => $request->rejection_description,
            'status' => 'rejected',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course rejected successfully',
        ]);
    }

    public function previewCourse(Course $course)
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

        return view('SuperAdmin.Course.preview', compact(
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
}
