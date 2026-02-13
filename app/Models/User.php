<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'image',
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function adminlte_profile_url()
    {
        switch ($this->role) {
            case 'teacher':
                return route('teacher.profile.index');

            case 'student':
                return route('student.profile.index');

            case 'super-admin':
                return url('/admin/profile');

            default:
                return '#';
        }
    }

    public function courses()  // changed to course for enrollmentslist for teacher
    {
        return $this->hasMany(Course::class, 'teacherId', 'id');
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class, 'studentId', 'id');
    }

    /**
     * Check if user is enrolled in a specific course
     */
    public function hasEnrolled($courseId)
    {
        return $this->enrollments()
            ->where('courseId', $courseId)
            ->exists();
    }

    /**
     * Get enrolled courses relationship
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'studentId', 'courseId')
            ->withTimestamps()
            ->withPivot('created_at');
    }
}
