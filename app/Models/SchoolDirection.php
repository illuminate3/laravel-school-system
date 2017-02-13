<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolDirection extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
}
