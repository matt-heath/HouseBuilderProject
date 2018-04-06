<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstateAgent extends Model
{
    //
    protected $fillable = [
        'company_name',
        'supplier_type',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function developments(){
        return $this->belongsToMany('App\Development')->withPivot('estate_agent_id','development_id');;
    }
}
