<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseType extends Model
{
    //
    protected $fillable = [

    ];

    public function plot(){
        return $this->belongsTo('App\Plot');
    }
}
