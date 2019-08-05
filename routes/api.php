<?php

Route::post('checkout-midtrans', 'ApiController@checkoutMidtrans');
Route::post('save-payment-midtrans/{id?}', 'ApiController@savePaymentMidtrans');
Route::any('notify-midtrans', 'ApiController@midtransNotification');