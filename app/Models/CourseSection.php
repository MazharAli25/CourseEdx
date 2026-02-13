<?php

// app/Models/Section.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'courseId', 'title',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId', 'id');
    }

    public function lectures()
    {
        return $this->hasMany(CourseLecture::class, 'sectionId', 'id');
    }
}