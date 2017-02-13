<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Visitor extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setStayFromAttribute($date)
    {
        $this->attributes['stay_from'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
    }

    public function getStayFromAttribute($date)
    {
        if ($date == "0000-00-00" || $date == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($date));
        }
    }

    public function setStayToAttribute($date)
    {
        $this->attributes['stay_to'] = Carbon::createFromFormat($this->date_format(), $date)->format('Y-m-d');
    }

    public function getStayToAttribute($date)
    {
        if ($date == "0000-00-00" || $date == "") {
            return "";
        } else {
            return date($this->date_format(), strtotime($date));
        }
    }

}
