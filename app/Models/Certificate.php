<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    public function getImageAttribute()
    {
        $image = $this->attributes['image'];
        if (!is_null($image))
            return asset('uploads/certificate/' . $image);

        return null;
    }

}
