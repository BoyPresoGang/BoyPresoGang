<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function createDelivery(Request $request)
    {
        $allowedStatuses = ['scheduled', 'in_transit', 'delivered', 'cancelled'];

        // Guard Clauses
        if (!$request->has('customer_id') || !is_numeric($request->input('customer_id'))) {
            return response()->json(['error' => 'customer_id is required and must be an integer'], 422);
        }

        if (!$request->has('delivery_date') || empty($request->input('delivery_date'))) {
            return response()->json(['error' => 'delivery_date is required'], 422);
        }

        if (!$request->has('status') || !in_array($request->input('status'), $allowedStatuses)) {
            return response()->json(['error' => 'status must be one of: scheduled, in_transit, delivered, cancelled'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Delivery validation passed'], 201);
    }

    public function updateDelivery(Request $request, $id)
    {
        $allowedStatuses = ['scheduled', 'in_transit', 'delivered', 'cancelled'];

        // Guard Clauses
        if ($request->has('customer_id') && !is_numeric($request->input('customer_id'))) {
            return response()->json(['error' => 'customer_id must be an integer'], 422);
        }

        if ($request->has('status') && !in_array($request->input('status'), $allowedStatuses)) {
            return response()->json(['error' => 'status must be one of: scheduled, in_transit, delivered, cancelled'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Delivery update validation passed', 'id' => $id], 200);
    }
}