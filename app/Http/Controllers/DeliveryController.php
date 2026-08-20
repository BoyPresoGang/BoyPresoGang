<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function listDeliveries() { return response()->json(['message' => 'listDeliveries stub'], 200); }
    public function createDelivery(Request $request) { return response()->json(['message' => 'createDelivery stub'], 201); }
    public function showDelivery(string $id) { return response()->json(['message' => 'showDelivery stub', 'id' => $id], 200); }
    public function updateDelivery(Request $request, string $id) { return response()->json(['message' => 'updateDelivery stub', 'id' => $id], 200); }
    public function deleteDelivery(string $id) { return response()->json(['message' => 'deleteDelivery stub', 'id' => $id], 200); }
}