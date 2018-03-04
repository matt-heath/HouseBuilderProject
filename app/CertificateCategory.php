<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateCategory extends Model
{
    //

    protected $fillable = [
        'name',
        'category_description'
    ];

    public function certificates(){
        return $this->HasMany('App\Certificate');
    }

    public function certificates_required(){
        return $this->HasMany('App\CertificateRequired');
    }
}
