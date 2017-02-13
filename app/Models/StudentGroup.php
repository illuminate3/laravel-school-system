<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class StudentGroup extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    public function getStudentsSelectAttribute()
    {
        return $this->students->pluck('id')->toArray();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
