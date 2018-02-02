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
    Route::resource('admin/certificates', 'AdminCertificatesController');
    Route::resource('admin/certificatecategories', 'AdminCertificateCategoriesController');
//    Route::post('/deleteCategory', 'AdminCertificateCategoriesController@destroy');
    Route::get('admin/viewuserbyrole/{id}', ['as'=>'admin.viewuserbyrole', 'uses'=>'AdminUsersController@viewUserByRole']);
    Route::get('admin/plotsbydevelopment/{id}', ['as'=>'admin.plotsbydevelopment', 'uses'=>'AdminPlotsController@plotsByDevelopment']);
    Route::get('/findHouseTypes', 'AdminPlotsController@findHouseTypes');
});

Route::group(['middleware'=>'estateagent'], function() {
    Route::get('/estateagent', function(){

        return view('estateagent.index');

    });

    Route::resource('estateagent/users', 'EstateAgentUsersController');
    Route::resource('estateagent/developments', 'EstateAgentDevelopmentsController');
    Route::resource('estateagent/booking', 'EstateAgentBookingsController');
    Route::get('estateagent/viewplots/{id}', ['as'=>'development.viewplots', 'uses'=>'EstateAgentDevelopmentsController@viewplots']);
    Route::get('estateagent/createbooking/{id}', ['as'=>'booking.create', 'uses'=>'EstateAgentBookingsController@create']);
    Route::get('/findUsersEmail', 'EstateAgentBookingsController@findUsersEmail');
});

Route::group(['middleware'=>'externalconsultant'], function() {
    Route::get('/externalconsultant', function(){

        return view('externalconsultant.index');

    });
});

Route::get('/home', 'HomeController@index');
