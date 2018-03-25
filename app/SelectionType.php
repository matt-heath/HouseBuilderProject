<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectionType extends Model
{
    //
    protected $fillable = [
        'type_name'
    ];

    public function variations(){
        return $this->belongsToMany('App\Variation');
    }

    public function categories() {
        return $this->belongsToMany('App\SelectionCategory')->withPivot('selection_category_id', 'selection_type_id');
    }
}
