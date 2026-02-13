<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLecture;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    public function curriculum(Course $course)
    {
        $course = $course;

        return view('Teacher.Course.curriculum', compact('course'));
    }

    public function curriculumStore(Request $request, Course $course)
    {
        $validated = $request->validate([
            'sections' => 'array',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.lectures' => 'array',
            'sections.*.lectures.*.title' => 'required|string|max:255',
            'sections.*.lectures.*.description' => 'nullable|string',
            'sections.*.lectures.*.video_url' => 'nullable|url',
            'sections.*.lectures.*.video_file' => 'nullable|file|mimes:mp4,mov,avi|max:512000',
        ]);

        // Track which sections/lectures exist after save
        $existingSectionIds = [];
        $existingLectureIds = [];

        foreach ($validated['sections'] as $sectionKey => $sectionData) {

            // Check if this is an existing section (numeric ID) or new (string like "new_0")
            if (is_numeric($sectionKey)) {
                // UPDATE existing section
                $section = CourseSection::find($sectionKey);
                if ($section && $section->courseId == $course->id) {
                    $section->update(['title' => $sectionData['title']]);
                    $existingSectionIds[] = $section->id;
                }
            } else {
                // CREATE new section
                $section = CourseSection::create([
                    'courseId' => $course->id,
                    'title' => $sectionData['title'],
                ]);
                $existingSectionIds[] = $section->id;
            }

            // Process lectures for this section
            if (isset($sectionData['lectures'])) {
                foreach ($sectionData['lectures'] as $lectureKey => $lectureData) {

                    if (is_numeric($lectureKey)) {
                        // UPDATE existing lecture
                        $lecture = CourseLecture::find($lectureKey);
                        if ($lecture && $lecture->sectionId == $section->id) {
                            $lecture->update([
                                'title' => $lectureData['title'],
                                'description' => $lectureData['description'] ?? null,
                                'videoUrl' => $lectureData['video_url'] ?? null,
                            ]);

                            // Handle video file upload for existing lecture
                            if (isset($lectureData['video_file'])) {
                                $file = $lectureData['video_file'];
                                $fileName = time().'_'.$file->getClientOriginalName();
                                $file->move(public_path('uploads/lectures'), $fileName);
                                $lecture->update(['videoFile' => 'uploads/lectures/'.$fileName]);
                            }

                            $existingLectureIds[] = $lecture->id;
                        }
                    } else {
                        // CREATE new lecture
                        $lecture = new CourseLecture;
                        $lecture->sectionId = $section->id;
                        $lecture->title = $lectureData['title'];
                        $lecture->description = $lectureData['description'] ?? null;
                        $lecture->videoUrl = $lectureData['video_url'] ?? null;

                        // Handle video file upload for new lecture
                        if (isset($lectureData['video_file'])) {
                            $file = $lectureData['video_file'];
                            $fileName = time().'_'.$file->getClientOriginalName();
                            $file->move(public_path('uploads/lectures'), $fileName);
                            $lecture->videoFile = 'uploads/lectures/'.$fileName;
                        }

                        $lecture->save();
                        $existingLectureIds[] = $lecture->id;
                    }
                }
            }
        }

        // Delete sections that were removed from the form
        CourseSection::where('courseId', $course->id)
            ->whereNotIn('id', $existingSectionIds)
            ->delete();

        // Delete lectures for sections that still exist
        CourseLecture::whereIn('sectionId', $existingSectionIds)
            ->whereNotIn('id', $existingLectureIds)
            ->delete();

        return redirect()->back()
            ->with('success', 'Course curriculum saved successfully.');
    }

    public function removeVideo(CourseLecture $lecture)
    {

        // Delete video file from storage
        if ($lecture->videoFile && Storage::exists($lecture->videoFile)) {
            Storage::delete($lecture->video_file);
        }

        // Clear video fields
        $lecture->update([
            'videoFile' => null,
            'videoUrl' => null,
        ]);

        return response()->json(['success' => true]);
    }

    // In CourseController.php

    /**
     * Delete a section via AJAX
     */
    public function destroySection(CourseSection $section)
    {
        try {
            // $this->authorize('delete', $section);

            // Delete all lectures first (cascade)
            $section->lectures()->delete();

            // Delete the section
            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Section deleted successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting section: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a lecture via AJAX
     */
    public function destroyLecture(CourseLecture $lecture)
    {
        try {

            // Delete video file if exists
            if ($lecture->video_file && Storage::exists($lecture->video_file)) {
                Storage::delete($lecture->video_file);
            }

            $lecture->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lecture deleted successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting lecture: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove video only (keep lecture)
     */
    public function removeSection(CourseSection $section)
    {
        $section->delete();

        return response()->json(['success' => true, 'message' => 'comming']);
    }

    public function removeLecture(CourseLecture $lecture)
    {
        $lecture->delete();

        return response()->json(['success' => true, 'message' => 'comming']);
    }
}
