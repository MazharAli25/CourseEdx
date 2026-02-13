<?php
// app/Traits/CourseBuilderTrait.php
namespace App\Traits;

trait CourseBuilderTrait
{
    public function isCourseReadyForPublish($course)
    {
        return $course->title && 
               $course->description &&
               $course->sections()->count() > 0 &&
               $course->lectures()->count() > 0 &&
               $course->requirements &&
               $course->price !== null &&
               $course->thumbnail;
    }
    
    public function calculateCompletion($course)
    {
        $steps = [
            'basic' => $course->title && $course->description ? 1 : 0,
            'curriculum' => $course->sections()->count() > 0 && 
                          $course->lectures()->count() > 0 ? 1 : 0,
            'requirements' => $course->requirements ? 1 : 0,
            'faqs' => $course->faqs()->count() > 0 ? 1 : 0,
            'pricing' => $course->price !== null ? 1 : 0,
            'thumbnail' => $course->thumbnail ? 1 : 0,
        ];
        
        $completed = array_sum($steps);
        $total = count($steps);
        
        return round(($completed / $total) * 100);
    }
    
    public function getCompletionText($course)
    {
        $progress = $this->calculateCompletion($course);
        
        if ($progress >= 100) {
            return 'Ready to publish!';
        } elseif ($progress >= 80) {
            return 'Almost there!';
        } elseif ($progress >= 50) {
            return 'Halfway done';
        } else {
            return 'Getting started';
        }
    }
}