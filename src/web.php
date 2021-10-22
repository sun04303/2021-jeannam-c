<?php
    use App\Route;

    Route::get('/', "ViewController@main");
    Route::get('/sub', "ViewController@sub");
    Route::get('/stamp', "ViewController@stamp");
    Route::get('/login', "ViewController@login");

    Route::post('/login', "ActionController@login");
    Route::get('/logout', 'ActionController@logout');
    Route::post('/search', 'ActionController@search');

    Route::start();