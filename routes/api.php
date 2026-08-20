<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Route;

// Customers
Route::get('/customers', [CustomerController::class, 'listCustomers']);
Route::post('/customers', [CustomerController::class, 'createCustomer']);
Route::get('/customers/{id}', [CustomerController::class, 'showCustomer']);
Route::put('/customers/{id}', [CustomerController::class, 'updateCustomer']);
Route::delete('/customers/{id}', [CustomerController::class, 'deleteCustomer']);

// Products
Route::get('/products', [ProductController::class, 'listProducts']);
Route::post('/products', [ProductController::class, 'createProduct']);
Route::get('/products/{id}', [ProductController::class, 'showProduct']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);

// Orders
Route::get('/orders', [OrderController::class, 'listOrders']);
Route::post('/orders', [OrderController::class, 'createOrder']);
Route::get('/orders/{id}', [OrderController::class, 'showOrder']);
Route::put('/orders/{id}', [OrderController::class, 'updateOrder']);
Route::delete('/orders/{id}', [OrderController::class, 'deleteOrder']);

// Deliveries
Route::get('/deliveries', [DeliveryController::class, 'listDeliveries']);
Route::post('/deliveries', [DeliveryController::class, 'createDelivery']);
Route::get('/deliveries/{id}', [DeliveryController::class, 'showDelivery']);
Route::put('/deliveries/{id}', [DeliveryController::class, 'updateDelivery']);
Route::delete('/deliveries/{id}', [DeliveryController::class, 'deleteDelivery']);