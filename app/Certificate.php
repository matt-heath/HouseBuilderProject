<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $fillable = [];

    //Set up many-to-many relationship - one
    public function plots() {
        return $this->belongsToMany('App\Plot');
    }

    public function category() {
        return $this->hasOne('App\CertificateCategory');
    }
}
