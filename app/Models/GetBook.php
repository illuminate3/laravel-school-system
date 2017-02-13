<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetBook extends Model
{
    protected $guarded = array('id');

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
