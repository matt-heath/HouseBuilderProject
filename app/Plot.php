<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    //

    protected $fillable = [
        'development_id',
        'plot_name',
        'house_type',
        'sqft',
        'phase',
        'status'
    ];


    public function development(){
        return $this->belongsTo('App\Development');
    }

    public function houseTypes(){
        return $this->hasOne('App\HouseType', 'id', 'house_type');
    }


//    // each development has one photo (example picture).
//    public function photo (){
//        return $this->belongsTo('App\Photo');
//    }
}
