<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/orders/create', 'orders.create');
Route::view('/deliveries/create', 'deliveries.create');