<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable= ['name', 'slug', 'description'];

    public function subcats(){
        return $this->hasMany(SubCategory::class, 'categoryId', 'id');
    }

    public function courses(){
        return $this->hasMany(Course::class, 'categoryId', 'id');
    }

}
