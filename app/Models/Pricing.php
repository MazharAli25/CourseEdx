<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable=['courseId', 'price', 'currency', 'currencySymbol'];

    public function course(){
        return $this->belongsTo( Course::class,'courseId', 'id');
    }
}
