<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Section extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function teacher()
    {
        return $this->belongsTo(User::class, 'section_teacher_id');
    }

    public function setSchoolYearIdAttribute($school_year_id)
    {
        $this->attributes['school_year_id'] = ($school_year_id != '') ? $school_year_id : session('current_school_year');
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function total()
    {
        return $this->hasMany(Student::class, 'section_id');
    }
}
