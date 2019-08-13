<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['api'], 'namespace' => 'professionalweb\IntegrationHub\IntegrationHub\Http\Controllers'], function () {
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/applications', 'ApplicationController@index');
        Route::get('/applications/{id}', 'ApplicationController@view');
        Route::post('/applications[/{id}]', 'ApplicationController@store');
        Route::delete('/applications/{id}', 'ApplicationController@destroy');
        Route::post('/applications/{id}/regenerate-keys', 'ApplicationController@regenerateTokens');

        Route::get('/events', 'EventController@index');
        Route::get('/events/{id}', 'EventController@view');
        Route::post('/events', 'EventController@store');
        Route::post('/events/{id}', 'EventController@store');
        Route::delete('/events/{id}', 'EventController@destroy');

        Route::get('/users', 'UserController@index');
        Route::get('/users/{id}', 'UserController@view');
        Route::post('/users', 'UserController@store');
        Route::post('/users/{id}', 'UserController@store');
        Route::delete('/users/{id}', 'UserController@destroy');
    });

    Route::group(['middleware' => ['b2bAuth']], function () {
        Route::post('events', 'EventController@store');
    });
});