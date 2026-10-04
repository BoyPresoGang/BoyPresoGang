<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Create Routes
|--------------------------------------------------------------------------
*/

Route::view('/orders/create', 'orders.create');
Route::view('/deliveries/create', 'deliveries.create');
Route::view('/customers/create', 'customers.create');
Route::view('/products/create', 'products.create');

/*
|--------------------------------------------------------------------------
| Index/List Routes
|--------------------------------------------------------------------------
*/

Route::view('/customers', 'customers.index');
Route::view('/products', 'products.index');
Route::view('/orders', 'orders.index');
Route::view('/deliveries', 'deliveries.index');

/*
|--------------------------------------------------------------------------
| Edit Routes
|--------------------------------------------------------------------------
*/

Route::view('/customers/edit/{id}', 'customers.edit');
Route::view('/products/edit/{id}', 'products.edit');
Route::view('/orders/edit/{id}', 'orders.edit');
Route::view('/deliveries/edit/{id}', 'deliveries.edit');

/*
|--------------------------------------------------------------------------
| Detail/Show Routes
|--------------------------------------------------------------------------
*/

Route::view('/customers/{id}', 'customers.show');
Route::view('/products/{id}', 'products.show');
Route::view('/orders/{id}', 'orders.show');
Route::view('/deliveries/{id}', 'deliveries.show');