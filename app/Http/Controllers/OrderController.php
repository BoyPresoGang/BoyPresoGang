<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function listOrders() { return response()->json(['message' => 'listOrders stub'], 200); }
    public function createOrder(Request $request) { return response()->json(['message' => 'createOrder stub'], 201); }
    public function showOrder(string $id) { return response()->json(['message' => 'showOrder stub', 'id' => $id], 200); }
    public function updateOrder(Request $request, string $id) { return response()->json(['message' => 'updateOrder stub', 'id' => $id], 200); }
    public function deleteOrder(string $id) { return response()->json(['message' => 'deleteOrder stub', 'id' => $id], 200); }
}