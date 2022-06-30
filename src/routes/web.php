<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['api'], 'namespace' => 'professionalweb\IntegrationHub\IntegrationHub\Http\Controllers'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/events', 'EventController@index');
        Route::get('/events/{id}', 'EventController@view');
        Route::post('/events', 'EventController@store');
        Route::post('/events/{id}', 'EventController@store');
        Route::delete('/events/{id}', 'EventController@destroy');
    });

    Route::group(['middleware' => ['b2bAuth']], function () {
        Route::post('events', 'EventController@store');
    });
});