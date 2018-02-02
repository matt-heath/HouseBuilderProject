<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    //

    public function certificates() {
        return $this->belongsTo('App\Certificate');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
