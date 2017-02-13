<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function teacher_subjects()
    {
        return $this->hasMany(TeacherSubject::class, 'subject_id');
    }

    public function mark_system()
    {
        return $this->belongsTo(MarkSystem::class, 'mark_system_id');
    }
}
