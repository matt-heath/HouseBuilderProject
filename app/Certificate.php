<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $fillable = [
        'certificate_name',
        'certificate_check',
        'certificate_doc',
        'certificate_category_id'
    ];

    //Set up many-to-many relationship - one
    public function plots() {
        return $this->hasMany('App\Plot');
    }

    public function category() {
        return $this->belongsTo('App\CertificateCategory', 'certificate_category_id', 'id');
    }

    public function consultant() {
        return $this->hasOne('App\Consultant');
    }

    public function rejection(){
        return $this->hasMany('App\CertificateRejection');
    }
}
