<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/development/{id}', ['as'=>'home.development', 'uses'=>'AdminDevelopmentsController@development']);


Route::group(['middleware'=>'admin'], function(){

    Route::get('/admin', function(){

        return view('admin.index');

    });

    Route::resource('admin/users', 'AdminUsersController');
    Route::resource('admin/developments', 'AdminDevelopmentsController');
    Route::resource('admin/plots', 'AdminPlotsController');
    Route::resource('admin/housetypes', 'AdminHouseTypesController');

});

Route::group(['middleware'=>'estateagent'], function() {


    Route::get('/estateagent', function(){

        return view('estateagent.index');

    });

    Route::resource('estateagent/users', 'EstateAgentUsersController');

});



Route::get('/home', 'HomeController@index');
