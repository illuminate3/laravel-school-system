<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function getStudentCardBackgroundAttribute()
    {
        $picture = $this->attributes['student_card_background'];
        return asset('uploads/student_card') . '/' . $picture;
    }

    public function getPhotoAttribute()
    {
        $picture = $this->attributes['photo'];
        return asset('uploads/school_photo') . '/' . $picture;
    }
}
