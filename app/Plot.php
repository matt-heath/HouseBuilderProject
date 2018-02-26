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
        'status',
        'build_status',
        'plot_name_id'
    ];


    public function development(){
        return $this->belongsTo('App\Development');
    }

    public function houseTypes(){
        return $this->hasOne('App\HouseType', 'id', 'house_type');
    }

    public function certificates() {
        return $this->belongsToMany('App\Certificate');
    }

}
