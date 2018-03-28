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
        return $this->belongsToMany('App\SelectionType')->withPivot('selection_type_id', 'selection_category_id');
    }
}
