<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('spa');
});

Route::get('/{pathMatch}', function () {
    return view('spa');
})->where('pathMatch','.*');
