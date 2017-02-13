<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model
{
    protected $guarded = array('id');

    public $timestamps = false;

    public $table = 'version';
}
