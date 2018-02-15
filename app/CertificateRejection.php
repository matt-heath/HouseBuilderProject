<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateRejection extends Model
{
    //

    protected $fillable = [
        'certificate_id',
        'rejection_reason'
    ];

    public function certificate(){
        return $this->belongsTo('App\Certificate');
    }
}
