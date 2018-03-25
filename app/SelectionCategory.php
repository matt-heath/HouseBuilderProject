<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectionCategory extends Model
{
    //

    protected $fillable = [
        'category_name'
    ];

    public function selectionType(){
        return $this->hasMany('App\SelectionType');
    }
}
