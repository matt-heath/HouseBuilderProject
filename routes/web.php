<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::get('/development/{id}', ['as'=>'home.development', 'uses'=>'AdminDevelopmentsController@development']);


Route::group(['middleware'=>'admin'], function(){

    Route::get('/admin', function(){

        return view('admin.index');

    });

    Route::resource('admin/users', 'AdminUsersController', ['names'=>[
        'index'=>'admin.users.index',
        'create'=>'admin.users.create',
        'store'=> 'admin.users.store',
        'edit'=> 'admin.users.edit'
    ]]);

    Route::resource('admin/developments', 'AdminDevelopmentsController',  ['names'=>[
        'index'=>'admin.developments.index',
        'create'=>'admin.developments.create',
        'store'=> 'admin.developments.store',
        'edit'=> 'admin.developments.edit'
    ]]);

    Route::resource('admin/plots', 'AdminPlotsController',  ['names'=>[
        'index'=>'admin.plots.index',
        'create'=>'admin.plots.create',
        'store'=> 'admin.plots.store',
        'edit'=> 'admin.plots.edit'
    ]]);

    Route::resource('admin/housetypes', 'AdminHouseTypesController',  ['names'=>[
        'index'=>'admin.housetypes.index',
        'create'=>'admin.housetypes.create',
        'store'=> 'admin.housetypes.store',
        'edit'=> 'admin.housetypes.edit'
    ]]);

    Route::resource('admin/certificates', 'AdminCertificatesController', ['names'=>[
        'index'=>'admin.certificates.index',
        'create'=>'admin.certificates.create',
        'store'=> 'admin.certificates.store',
        'edit'=> 'admin.certificates.edit'
    ]]);

    Route::resource('admin/consultants', 'AdminConsultantsController', ['names'=>[
        'index'=>'admin.consultants.index',
        'create'=>'admin.consultants.create',
        'store'=> 'admin.consultants.store',
        'edit'=> 'admin.consultants.edit'
    ]]);


    Route::resource('admin/certificatecategories', 'AdminCertificateCategoriesController', ['names'=>[
        'index'=>'admin.certificatecategories.index',
        'create'=>'admin.certificatecategories.create',
        'store'=> 'admin.certificatecategories.store',
        'edit'=> 'admin.certificatecategories.edit'
    ]]);

    Route::resource('admin/booking', 'AdminBookingsController', ['names'=>[
        'index'=>'admin.booking.index',
        'create'=>'admin.booking.create',
        'store'=> 'admin.booking.store',
        'edit'=> 'admin.booking.edit'
    ]]);

//    Route::post('/deleteCategory', 'AdminCertificateCategoriesController@destroy');
    Route::get('admin/viewuserbyrole/{id}', ['as'=>'admin.viewuserbyrole', 'uses'=>'AdminUsersController@viewUserByRole']);
    Route::get('admin/plotsbydevelopment/{id}', ['as'=>'admin.plotsbydevelopment', 'uses'=>'AdminPlotsController@plotsByDevelopment']);
    Route::get('/findHouseTypes', 'AdminPlotsController@findHouseTypes');
    Route::get('/developmentPhases', 'AdminPlotsController@developmentPhases');
    Route::get('/findPhases', 'AdminConsultantsController@findPhases');
    Route::get('/findPlots', 'AdminConsultantsController@findPlots');
    Route::get('/getRejectionReasons', 'AdminCertificatesController@getRejectionReasons');
    Route::get('/download/{file}', 'DownloadsController@download');
    Route::post('/addUser', 'AdminUsersController@addUser');
});


Route::group(['middleware'=>'estateagent'], function() {
    Route::get('/estateagent', function(){

        return view('estateagent.index');

    });

    Route::resource('estateagent/users', 'EstateAgentUsersController', ['names'=>[
        'index'=>'estateagent.users.index',
        'create'=>'estateagent.users.create',
        'store'=> 'estateagent.users.store',
        'edit'=> 'estateagent.users.edit'
    ]]);

    Route::resource('estateagent/developments', 'EstateAgentDevelopmentsController', ['names'=>[
        'index'=>'estateagent.developments.index',
        'create'=>'estateagent.developments.create',
        'store'=> 'estateagent.developments.store',
        'edit'=> 'estateagent.developments.edit'
    ]]);

    Route::resource('estateagent/booking', 'EstateAgentBookingsController', ['names'=>[
        'index'=>'estateagent.booking.index',
        'create'=>'estateagent.booking.create',
        'store'=> 'estateagent.booking.store',
        'edit'=> 'estateagent.booking.edit'
    ]]);

    Route::get('estateagent/viewplots/{id}', ['as'=>'development.viewplots', 'uses'=>'EstateAgentDevelopmentsController@viewplots']);
    Route::get('estateagent/createbooking/{id}', ['as'=>'booking.create', 'uses'=>'EstateAgentBookingsController@create']);
    Route::get('/findUsersEmail', 'EstateAgentBookingsController@findUsersEmail');
});

Route::group(['middleware'=>'externalconsultant'], function() {
    Route::get('/externalconsultant', function(){

        return view('externalconsultant.index');

    });

    Route::resource('externalconsultant/plots', 'ExternalConsultantPlotsController', ['names'=>[
        'index'=>'externalconsultant.plots.index',
        'create'=>'externalconsultant.plots.create',
        'store'=> 'externalconsultant.plots.store',
        'edit'=> 'externalconsultant.plots.edit'
    ]]);
    Route::resource('externalconsultant/certificates', 'ExternalConsultantCertificatesController', ['names'=>[
        'index'=>'externalconsultant.certificates.index',
        'create'=>'externalconsultant.certificates.create',
        'store'=> 'externalconsultant.certificates.store',
        'edit'=> 'externalconsultant.certificates.edit'
    ]]);
});

Route::get('/home', 'HomeController@index');
Route::get('/getRejectionReasons', 'AdminCertificatesController@getRejectionReasons');


