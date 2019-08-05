<?php

Route::group(['prefix' => 'rotate', 'namespace' => 'CsRotate'], function () {
    Route::get('/', 'CsRotateController@index');
    Route::get('/detail-rotate/{id?}', 'CsRotateController@detailRotate');
    Route::get('/form-rotate/{id?}', 'CsRotateController@formRotate');
    Route::post('/save-rotate/{id?}', 'CsRotateController@saveRotate');
    Route::get('/delete-rotate/{id?}', 'CsRotateController@deleteRotate');

    Route::get('/detail-sub/{id?}', 'CsRotateController@detailSubRotate');
    Route::get('/form-sub/{rotate_id?}/{sub_id?}', 'CsRotateController@formSubRotate');
    Route::post('/form-sub/{rotate_id?}/{sub_id?}', 'CsRotateController@saveSubRotate');
    Route::post('/delete-sub/{id?}', 'CsRotateController@deleteSubRotate');

    Route::get('/log', 'CsRotateController@log');
    Route::get('/detail-log/{id?}', 'CsRotateController@detailLog');


    Route::get('/sub-table/{subId?}', 'CsRotateController@getTableScheduleSub');
    Route::get('/schedule-delete/{subId?}/{scheduleId?}', 'CsRotateController@deleteScheduleSub');
    Route::get('/schedule-form/{subId?}/{scheduleId?}', 'CsRotateController@getFormScheduleSub');
    Route::post('/schedule-save/{subId?}/{scheduleId?}', 'CsRotateController@saveScheduleSub');
});