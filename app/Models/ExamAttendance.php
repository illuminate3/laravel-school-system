<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAttendance extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
