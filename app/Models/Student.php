<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Student extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function behavior()
    {
        return $this->belongsToMany(Behavior::class)->withTimestamps();
    }

    public function studentsgroups()
    {
        return $this->belongsToMany(StudentGroup::class)->withTimestamps();
    }

    public function bed()
    {
        return $this->hasOne(DormitoryBed::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

}
