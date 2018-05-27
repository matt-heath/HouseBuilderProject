<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phases extends Model
{
    //
    protected $fillable = [
        'development_id',
        'phase_name',
        'created_at',
        'updated_at'
    ];
//
   public function plot (){
       return $this->belongsTo('App\Plot');
   }
}
