<?php

Route::get('/', 'IndexController@index');

Route::group(['prefix' => 'event'], function () {
    Route::get('/', 'IndexController@allEvent');
    Route::get('{event?}', 'IndexController@listevent');
    Route::get('{event?}/{id?}', 'IndexController@viewEvent');
});

Route::post('registration', 'IndexController@registration');
Route::get('payment', 'IndexController@payment');

Route::group(['prefix' => 'backend', 'namespace' => 'Backend', 'middleware' => ["admin.not-login"]], function () {
    Route::get('login', 'Auth\LoginController@index');
    Route::post('login/authenticate', 'Auth\LoginController@authenticate');
    Route::get('reset', 'Auth\LoginController@reset');
    Route::post('reset-password', 'Auth\LoginController@resetPassword');
    Route::get('reset-token/{token?}', 'Auth\LoginController@resetToken');
    Route::post('change-password/{token?}', 'Auth\LoginController@changePass');
});

Route::group(['prefix' => 'backend', 'namespace' => 'Backend', 'middleware' => ['auth.admin']], function () {
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('', 'DashboardController@index');
    Route::get('index', 'DashboardController@index');
    Route::get('dashboard', 'DashboardController@index');
    foreach (glob("../routes/backend/*.route.php") as $filename) {
        include $filename;
    }
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    // return what you want
});