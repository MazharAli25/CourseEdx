<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureMaterial extends Model
{
    protected $fillable = [
        'lectureId', 'fileName', 'filePath', 'fileType'
    ];

    public function lecture(){
        return $this->belongsTo(CourseLecture::class, 'lectureId', 'id');
    }
}
