<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable = [
        'supplier_company_name',
        'supplier_type',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function selectionCategory(){
        return $this->hasOne('App\SelectionCategory', 'id', 'supplier_type');
    }

    public function variations(){
        return $this->hasMany('App\Variation');
    }

    public function developments(){
        return $this->belongsToMany('App\Development');
    }
}
