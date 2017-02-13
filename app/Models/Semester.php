<?php

namespace App\Models;

use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function date_format()
    {
        return Settings::get('date_format');
    }

    public function setStartAttribute($start)
    {
        $this->attributes['start'] = Carbon::createFromFormat($this->date_format(), $start)->format('Y-m-d');
    }

    public function getStartAttribute($start)
    {
        if ($start == "0000-00-00" || $start == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($start));
        }
    }

    public function setEndAttribute($end)
    {
        $this->attributes['end'] = Carbon::createFromFormat($this->date_format(), $end)->format('Y-m-d');
    }

    public function getEndAttribute($end)
    {
        if ($end == "0000-00-00" || $end == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($end));
        }
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'school_year_id', 'school_year_id');
    }

}
