<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    //
    protected $fillable = [
        'user_id',
        'consultant_description'
    ];

    public function certificates() {
        return $this->belongsToMany('App\Certificate');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
