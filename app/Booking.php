<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //

    protected $fillable = [
        'development_name',
        'user_id',
        'plot_id',
        'status',
        'title',
        'correspondence_address',
        'telephone_num',
        'email_address',
        'buyer_status'
    ];

    public function development(){
        return $this->belongsTo('App\Development');
    }
    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function plot(){
        return $this->hasOne('App\Plot', 'id', 'plot_id');
    }

    public function variations(){
        return $this->belongsToMany('App\Variation')->withPivot('booking_id', 'variation_id');
    }
}
