<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'categoryId',
        'name',
        'slug',
    ];

    public function category(){
        return $this->belongsTo(Categories::class, 'categoryId', 'id');
    }

    public function course(){
        return $this->hasMany(Course::class, 'subcategoryId', 'id');
    }
}
