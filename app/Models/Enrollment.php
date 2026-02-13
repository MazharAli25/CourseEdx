<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'studentId',
        'courseId',
    ];

    public function student(){
        return $this->belongsTo(User::class, 'studentId', 'id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'courseId', 'id');
    }
}
