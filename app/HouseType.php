<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseType extends Model
{
    //
    protected $fillable = [
        'development_id',
        'house_type_name',
        'house_type_desc',
        'floor_plan',
        'house_img'
    ];

    public function development(){
        return $this->belongsTo('App\Development');
    }

    public function plot (){
        return $this->belongsTo('App\Plot');
    }

    public function photo (){
        return $this->belongsTo('App\Photo', 'floor_plan');
    }
    public function house_photo (){
        return $this->belongsTo('App\Photo', 'house_img');
    }

    public function variations() {
        return $this->belongsToMany('App\Variation')->withPivot('house_type_id', 'variation_id');
    }
}
