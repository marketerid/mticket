<?php

Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
    Route::get('/', 'UserController@viewProfile');
    Route::get('/order-detail/{id?}', 'UserController@orderDetail');
    Route::get('/invoice/{id?}', 'UserController@invoiceDetail');
    Route::get('/payment/{id?}', 'UserController@makePayment');

    Route::get('/edit-profile', 'UserController@formProfile');
    Route::post('/save-profile', 'UserController@saveProfile');

    Route::get('/edit-password', 'UserController@formPassword');
    Route::post('/save-password', 'UserController@savePassword');

    Route::get('/confirm-payment/{id?}', 'UserController@confirmPayment');
    Route::post('/save-confirm-payment/{id?}', 'UserController@saveConfirmPayment');

    Route::get('/buy-sms', 'UserController@buySms');
    Route::post('/buy-sms-process', 'UserController@buySmsProcess');

    Route::get('/invoice-list', 'UserController@invoice');
    Route::get('/upgrade', 'UserController@upgrade');
    Route::get('/upgrade-now', 'UserController@upgradeNow');


    Route::get('/notification-ajax', 'UserController@notificationAjax');
    Route::get('/notification', 'UserController@notification');
    Route::get('/notification/{id?}', 'UserController@notificationDetail');
});