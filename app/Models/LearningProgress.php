<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningProgress extends Model
{
    use HasFactory;

    protected $table = 'lecture_progress';

    protected $fillable = [
        'userId',
        'courseId',
        'sectionId',
        'lectureId',
        'is_completed',
        'watch_duration',
        'last_watched_at',
    ];

    protected $casts = [
        'isCompleted' => 'boolean',
        'lastWatchedAt' => 'datetime',
    ];

    /**
     * Get the user that owns this progress record
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * Get the course that this progress belongs to
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId', 'id');
    }

    /**
     * Get the section that this progress belongs to
     */
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'sectionId', 'id');
    }

    /**
     * Get the lecture that this progress belongs to
     */
    public function lecture()
    {
        return $this->belongsTo(CourseLecture::class, 'lectureId', 'id');
    }

    /**
     * Scope a query to only include completed lectures
     */
    public function scopeCompleted($query)
    {
        return $query->where('isCompleted', true);
    }

    /**
     * Scope a query to only include incomplete lectures
     */
    public function scopeIncomplete($query)
    {
        return $query->where('isCompleted', false);
    }
}