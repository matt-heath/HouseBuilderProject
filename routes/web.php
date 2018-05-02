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

//    Route::get('/admin', function(){
//
//        return view('admin.index');
//
//    });

    Route::get('/admin', 'DashboardController@admin');

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
        'edit'=> 'admin.developments.edit',
        'show' => 'admin.developments.show',
        'update' => 'admin.developments.update'
    ]]);

    Route::resource('admin/plots', 'AdminPlotsController',  ['names'=>[
        'index'=>'admin.plots.index',
        'create'=>'admin.plots.create',
        'store'=> 'admin.plots.store',
        'edit'=> 'admin.plots.edit',
        'show'=> 'admin.plots.show'
    ]]);

    Route::resource('admin/housetypes', 'AdminHouseTypesController',  ['names'=>[
        'index'=>'admin.housetypes.index',
        'create'=>'admin.housetypes.create',
        'store'=> 'admin.housetypes.store',
        'edit'=> 'admin.housetypes.edit',
        'show'=> 'admin.housetypes.show'
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
    Route::resource('admin/suppliers', 'SupplierController', ['names'=>[
        'index'=>'admin.suppliers.index',
        'edit'=>'admin.suppliers.edit',
        'show' => 'admin.suppliers.show'
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

    Route::resource('admin/variations', 'VariationController', ['names' => [
//        'create' => 'admin.variations.create',
        'edit' => 'admin.variations.edit'
    ]]);

//    Route::post('/deleteCategory', 'AdminCertificateCategoriesController@destroy');
    Route::get('admin/viewuserbyrole/{id}', ['as'=>'admin.viewuserbyrole', 'uses'=>'AdminUsersController@viewUserByRole']);
    Route::get('admin/plotsbydevelopment/{id}', ['as'=>'admin.plotsbydevelopment', 'uses'=>'AdminPlotsController@plotsByDevelopment']);
    Route::get('/findHouseTypes', 'AdminPlotsController@findHouseTypes');
    Route::get('/developmentPhases', 'AdminPlotsController@developmentPhases');
    Route::get('/findPhases', 'AdminConsultantsController@findPhases');
    Route::get('/getPhases', 'AdminCertificatesController@getPhases');
    Route::get('/findPlots', 'AdminConsultantsController@findPlots');
    Route::get('/getHouseTypes', 'AdminConsultantsController@getHouseTypes');
    Route::get('/getRejectionReasons', 'AdminCertificatesController@getRejectionReasons');
    Route::get('/download/{file}', 'DownloadsController@download');
    Route::post('/addUser', 'AdminUsersController@addUser');
    Route::get('/getUsers', 'AdminUsersController@getUsers');
    Route::post('/createCertificate', 'AdminCertificatesController@createCertificate');
    Route::get('admin/variations/create/{id}', ['as'=>'admin.variations.create', 'uses'=>'VariationController@createVariation']);
    Route::get('admin/developments/{devID}/assignSupplier/{id}', ['as'=>'admin.developments.assignSupplier', 'uses'=> 'AdminDevelopmentsController@assignSupplier']);
    Route::post('/assignSupplierStore', ['as'=>'admin.developments.assignSupplierStore', 'uses'=> 'AdminDevelopmentsController@assignSupplierStore']);
    Route::post('/assignToHouseType', ['as'=>'admin.housetypes.assignToHouseType', 'uses'=> 'VariationController@assignToHouseType']);
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
        'edit'=> 'estateagent.developments.edit',
        'show'=> 'estateagent.developments.show'
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
    Route::post('/addBuyer', 'EstateAgentUsersController@addBuyer');

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

Route::group(['middleware'=>'buyer'], function() {
    Route::get('/buyer', function(){
        return view('buyer.index');
    });

    Route::resource('buyer/plot', 'BuyerPlotController', ['names'=>[
        'index'=>'buyer.plot.index',
//        'create'=>'externalconsultant.plots.create',
//        'store'=> 'externalconsultant.plots.store',
//        'edit'=> 'externalconsultant.plots.edit'
//        'show' => 'buyer.plot.show'
    ]]);

    Route::resource('buyer/variations', 'BuyerVariationController', ['names'=> [
        'edit'=> 'buyer.variations.edit',
        'update'=> 'buyer.variations.update'
    ]]);

});
Route::get('/home', 'HomeController@index');
Route::get('/getRejectionReasons', 'AdminCertificatesController@getRejectionReasons');



//Auth::routes();

Route::group(['prefix' => 'admin','namespace' => 'Auth'],function(){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.token');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::get('/home', 'HomeController@index')->name('home');
