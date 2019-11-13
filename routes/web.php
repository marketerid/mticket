<?php

Route::get('/', 'IndexController@index');

Route::group(['prefix' => 'event'], function () {
    Route::get('/', 'IndexController@allEvent');
    Route::get('{event?}', 'IndexController@listevent');
    Route::get('{event?}/{id?}', 'IndexController@viewEvent');
});

Route::get('search', 'IndexController@searchEvent');

Route::get('search-invoice', 'IndexController@searchInvoice');
Route::any('search-invoice/check', 'IndexController@searchInvoiceCheck');

Route::post('registration', 'RegistrationController@index');
Route::get('payment', 'RegistrationController@payment');

Route::get('tiket-download', 'RegistrationController@tiketDownload');

Route::get('reg/{id}', 'IndexController@regId');






















Route::get('about-us', function () {
    return view('frontend.pages.about');
});
Route::get('terms-condition', function () {
    return view('frontend.pages.terms');
});
Route::get('refund-policy', function () {
    return view('frontend.pages.refund');
});





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
