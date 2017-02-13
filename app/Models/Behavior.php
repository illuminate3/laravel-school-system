<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Behavior extends Model
{
    protected $guarded = array('id');

    public function students()
    {
        return $this->belongsToMany(Student::class, 'behavior_student');
    }
}
