<?php

Route::group(['prefix' => 'event'], function () {
    Route::get('/', 'EventController@index')->name('event.index');
    Route::get('create', 'EventController@create')->name('event.create');
    Route::post('store', 'EventController@store')->name('event.store');
    Route::get('edit/{id}', 'EventController@edit')->name('event.edit');
    Route::get('detail/{id}', 'EventController@detail')->name('event.detail');
    Route::put('update/{id}', 'EventController@update')->name('event.update');
    Route::get('delete', 'EventController@delete')->name('event.delete');
});