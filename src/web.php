<?php
    use App\Route;

    Route::get('/', "ViewController@main");
    Route::get('/sub', "ViewController@sub");
    Route::get('/stamp', "ViewController@stamp");
    Route::get('/login', "ViewController@login");
    Route::get('/order', 'ViewController@order');
    Route::get('/mypage', 'ViewController@mypage');

    Route::post('/login', "ActionController@login");
    Route::get('/logout', 'ActionController@logout');
    Route::post('/search', 'ActionController@search');
    Route::post('/orderok', 'ActionController@orderok');
    Route::post('/uprstate', "ActionController@uprstate");
    Route::post("/uplocation", "ActionController@uplocation");
    Route::post("/uptransport", "ActionController@uptransport");

    Route::start();