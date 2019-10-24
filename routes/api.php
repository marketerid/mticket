<?php

Route::post('checkout-midtrans', 'ApiController@checkoutMidtrans');
Route::post('save-payment-midtrans/{id?}', 'ApiController@savePaymentMidtrans');
Route::post('notify-midtrans', 'ApiController@paymentNotificationMidtrans');

Route::get('get-seminar', 'ApiController@getSeminar');
Route::get('change-status-event', 'ApiController@changeStatusEvent');

Route::get('u/{invoice?}', 'RegistrationController@getInfoUser');
