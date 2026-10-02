<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/orders/create', 'orders.create');
Route::view('/deliveries/create', 'deliveries.create');
Route::view('/customers/create', 'customers.create');
Route::view('/products/create', 'products.create');