<?php

Route::group(['prefix' => 'registration'], function () {
    Route::get('/', 'RegistrationController@index');
});