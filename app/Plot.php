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

    public function houseType(){
        return $this->hasMany('App\HouseType');
    }

}
