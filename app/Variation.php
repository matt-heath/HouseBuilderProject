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
}
