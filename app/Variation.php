<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'extra_img',
        'supplier_id'
    ];

    public function supplier() {
        return $this->belongsTo('App\Supplier');
    }

    public function selectionType(){
        return $this->belongsToMany('App\SelectionType')->withPivot('selection_type_id', 'variation_id');
    }

    public function photo (){
        return $this->belongsTo('App\Photo', 'extra_img', 'id');
    }
    public function houseTypes (){
        return $this->belongsToMany('App\HouseType')->withPivot('house_type_id', 'variation_id');
    }

    public function booking(){
        return $this->belongsToMany('App\Booking')->withPivot('variation_id', 'booking_id');
    }

//    public function category(){
//        return $this->belongsToMany('App\SelectionCategory')->withPivot('variation_id', 'booking_id');
//    }
}
