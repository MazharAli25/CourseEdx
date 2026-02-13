<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'level',
        'language',
        'thumbnail',
        'categoryId',
        'subcategoryId',
        'teacherId',
        'status',
        'rejection_title',
        'rejection_description',
    ];

    public function sections()
    {
        return $this->hasMany(CourseSection::class, 'courseId', 'id');
    }

    public function faqs()
    {
        return $this->hasMany(FAQ::class, 'courseId', 'id');
    }

    public function pricing()
    {
        return $this->hasOne(Pricing::class, 'courseId', 'id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'courseId', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'categoryId', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategoryId', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacherId', 'id');
    }

    public function lectures()
    {
        return $this->hasManyThrough(
            CourseLecture::class,
            CourseSection::class,
            'courseId', // Foreign key on course_sections table
            'sectionId', // Foreign key on course_lectures table
            'id', // Local key on courses table
            'id' // Local key on course_sections table
        );
    }
}
