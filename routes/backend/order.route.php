<?php

Route::group(['prefix' => 'order', 'as' => 'order.', 'namespace' => 'Order'], function () {
    Route::get('/', 'OrderController@index');
    Route::get('/detail/{id?}', 'OrderController@detail');
    Route::get('/custom-sms/{id?}', 'OrderController@customSmsForm');
    Route::post('/custom-sms-save/{id?}', 'OrderController@customSmsSave');


    Route::post('/confirm-paid-save/{id?}', 'OrderController@confirmPaid');
    Route::post('/admin-note/{id?}', 'OrderController@updateNote');
});