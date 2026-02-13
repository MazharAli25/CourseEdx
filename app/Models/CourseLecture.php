<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLecture extends Model
{
    use HasFactory;


    protected $fillable = [
        'sectionId',
        'title',
        'description',
        'videoUrl',
        'videoFile',
    ];

    // Relationships
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'sectionId', 'id');
    }

    public function materials(){
        return $this->hasMany(LectureMaterial::class, 'lectureId', 'id');
    }

}