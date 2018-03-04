<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateRequired extends Model
{
    //

    protected $table = "certificates_required";

    protected $fillable = [
        'certificate_category_id',
        'certificate_name'
    ];

    public function certificate(){
        return $this->belongsTo('App\Certificate');
    }

    public function certificateCategory(){
        return $this->belongsTo('App\CertificateCategory');
    }
}
