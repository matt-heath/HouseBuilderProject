<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Development extends Model
{
    //

    protected $fillable = [

        'development_name',
        'development_location',
        'development_num_plots',
        'development_description',
        'photo_id'

    ];


    public function plot(){
        return $this->hasMany('App\Plot');
    }

    public function houseTypes(){
        return $this->hasMany('App\HouseType');
    }

    // each development has one photo (example picture).
    public function photo (){
        return $this->belongsTo('App\Photo');
    }
}
