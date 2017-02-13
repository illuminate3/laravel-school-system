<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificateUser extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'certificate_user';

    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

}
