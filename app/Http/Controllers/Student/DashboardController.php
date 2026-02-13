<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLecture;
use App\Models\LearningProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display student dashboard
     */
    public function index()
    {
        $student = Auth::user();

        // Get enrolled courses with progress
        $enrolledCourses = $student->enrolledCourses()
            ->with(['teacher', 'category'])
            ->withCount(['lectures as total_lectures' => function ($q) {
                $q->whereHas('section');
            }])
            ->get();

        // Calculate progress for each course
        foreach ($enrolledCourses as $course) {
            $course->completed_lectures = LearningProgress::where('userId', $student->id)
                ->where('courseId', $course->id)
                ->where('is_completed', true)
                ->count();

            $course->progress_percentage = $course->total_lectures > 0
                ? round(($course->completed_lectures / $course->total_lectures) * 100)
                : 0;
        }

        return view('Student.dashboard', compact('enrolledCourses'));
    }

    /**
     * Display the learning page for a specific course
     */
    public function learning(Course $course)
    {
        // Get authenticated student
        $student = Auth::user();

        // Check if student is enrolled
        if (! $student->hasEnrolled($course->id)) {
            return redirect()->route('user.courseShow', $course->slug)
                ->with('error', 'Please enroll in this course first to start learning.');
        }

        // Load course with all necessary relationships
        $course->load([
            'category',
            'teacher',
            'sections' => function ($q) {
                $q->orderBy('id', 'asc');
            },
            'sections.lectures' => function ($q) {
                $q->orderBy('id', 'asc');
            },
        ]);

        // Get total lectures count for this course
        $totalLectures = CourseLecture::whereHas('section', function ($q) use ($course) {
            $q->where('courseId', $course->id);
        })->count();

        // Get completed lectures count for this student
        $completedLectures = LearningProgress::where('courseId', $course->id)
            ->where('userId', $student->id)  // ← USE studentId
            ->where('is_completed', true)
            ->count();

        // Calculate completion percentage
        $completionPercentage = $totalLectures > 0
            ? round(($completedLectures / $totalLectures) * 100)
            : 0;

        // Get IDs of completed lectures for easy checking in blade
        $completedLectureIds = LearningProgress::where('courseId', $course->id)
            ->where('userId', $student->id)
            ->where('is_completed', true)
            ->pluck('lectureId')
            ->toArray();

        // Get last watched lecture (if any)
        $lastWatched = LearningProgress::where('courseId', $course->id)
            ->where('userId', $student->id)
            ->with('lecture')
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('User.Courses.learning', compact(
            'course',
            'totalLectures',
            'completedLectures',
            'completionPercentage',
            'completedLectureIds',
            'lastWatched'
        ));
    }

    /**
     * Mark a lecture as complete
     */
    public function markLectureComplete(Request $request, CourseLecture $lecture)
    {
        try {
            $student = Auth::user();
            $section = $lecture->section;
            $course = $section->course;

            // Validate that student is enrolled in this course
            if (! $student->hasEnrolled($course->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not enrolled in this course',
                ], 403);
            }

            // Update or create progress record
            $progress = LearningProgress::updateOrCreate(
                [
                    'userId' => $student->id,
                    'lectureId' => $lecture->id,
                ],
                [
                    'courseId' => $course->id,
                    'sectionId' => $section->id,
                    'is_completed' => true,
                    'last_watched_at' => now(),
                ]
            );

            // Get updated counts
            $completedLectures = LearningProgress::where('courseId', $course->id)
                ->where('userId', $student->id)
                ->where('is_completed', true)
                ->count();

            $totalLectures = CourseLecture::whereHas('section', function ($q) use ($course) {
                $q->where('courseId', $course->id);
            })->count();

            $completionPercentage = $totalLectures > 0
                ? round(($completedLectures / $totalLectures) * 100)
                : 0;

            // Check if course is fully completed
            $isCourseCompleted = $completedLectures >= $totalLectures;

            // If course is completed, you could trigger an event or award certificate here
            if ($isCourseCompleted) {
                // TODO: Generate certificate, send congratulatory email, etc.
            }

            return response()->json([
                'success' => true,
                'completed_lectures' => $completedLectures,
                'total_lectures' => $totalLectures,
                'completion_percentage' => $completionPercentage,
                'is_course_completed' => $isCourseCompleted,
                'message' => 'Lecture marked as complete',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark lecture as complete: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Track video watching progress (optional)
     */
    public function trackProgress(Request $request, CourseLecture $lecture)
    {
        try {
            $student = Auth::user();
            $section = $lecture->section;
            $course = $section->course;

            // Validate that student is enrolled
            if (! $student->hasEnrolled($course->id)) {
                return response()->json(['success' => false], 403);
            }

            // Update or create progress record (don't mark as complete, just track watch time)
            LearningProgress::updateOrCreate(
                [
                    'userId' => $student->id,
                    'lectureId' => $lecture->id,
                ],
                [
                    'courseId' => $course->id,
                    'sectionId' => $section->id,
                    'watch_duration' => $request->duration ?? 0,
                    'last_watched_at' => now(),
                ]
            );

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
