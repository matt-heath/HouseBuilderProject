<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','photo_id','is_active','',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function role(){

        return $this->belongsTo('App\Role');


    }

    public function booking(){
        return $this->hasOne('App\Booking');
    }

    public function getConsultantDetailsAttribute()
    {
        return $this->name . " (" . $this->email .")";
    }

    public function getSupplierDetailsAttribute()
    {
        return $this->name . " (" . $this->email .")";
    }



//    public function photo(){
//
//
//        return $this->belongsTo('App\Photo');
//
//
//    }




//    public function setPasswordAttribute($password){
//
//
//        if(!empty($password)){
//
//
//            $this->attributes['password'] = bcrypt($password);
//
//
//        }
//
//
//        $this->attributes['password'] = $password;
//
//
//
//
//    }

    public function consultant() {
        return $this->hasOne('App\Consultant');
    }

    public function supplier() {
        return $this->hasOne('App\Supplier');
    }


    public function isAdmin(){
        if($this->role->name  == "Administrator" && $this->is_active == 1){
            return true;
        }
        return false;
    }

    public function isBuyer(){
        if($this->role->name  == "Buyer" && $this->is_active == 1){
            return true;
        }
        return false;
    }

    public function isEstateAgent(){
        if($this->role->name  == "Estate Agent" && $this->is_active == 1){
            return true;
        }
        return false;
    }

    public function isExternalConsultant(){
        if($this->role->name  == "External Consultant" && $this->is_active == 1){
            return true;
        }
        return false;
    }

//    public function developments(){
//
//        return $this->hasMany('App\Development');
//
//    }


    public function getGravatarAttribute(){


        $hash = md5(strtolower(trim($this->attributes['email']))) . "?d=mm&s=";
        return "http://www.gravatar.com/avatar/$hash";


    }





}
