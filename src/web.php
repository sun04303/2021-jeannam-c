<?php
    use App\Route;

    Route::get('/', "ViewController@main");
    Route::get('/sub', "ViewController@sub");
    Route::get('/stamp', "ViewController@stamp");

    Route::start();