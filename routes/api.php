<?php

Route::post('checkout-midtrans', 'ApiController@checkoutMidtrans');
Route::post('save-payment-midtrans/{id?}', 'ApiController@savePaymentMidtrans');
Route::post('notify-midtrans', 'ApiController@paymentNotificationMidtrans');
Route::get('get-events', 'ApiController@getEvents');
Route::get('get-registrations', 'ApiController@getRegistrations');