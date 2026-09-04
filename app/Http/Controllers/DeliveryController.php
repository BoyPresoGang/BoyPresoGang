<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function createDelivery(Request $request)
    {
        $allowedStatuses = ['scheduled', 'in_transit', 'delivered', 'cancelled'];

        // Guard Clauses (Task 2 & 3)
        if (!$request->has('customer_id') || !is_numeric($request->input('customer_id'))) {
            return response()->json([
                'status' => 422,
                'error' => 'customer_id is required and must be an integer',
                'field' => 'customer_id'
            ], 422);
        }

        if (!$request->has('delivery_date') || empty($request->input('delivery_date'))) {
            return response()->json([
                'status' => 422,
                'error' => 'delivery_date is required',
                'field' => 'delivery_date'
            ], 422);
        }

        if (!$request->has('status') || !in_array($request->input('status'), $allowedStatuses)) {
            return response()->json([
                'status' => 422,
                'error' => 'status must be one of: scheduled, in_transit, delivered, cancelled',
                'field' => 'status'
            ], 422);
        }

        return response()->json(['message' => 'Delivery created successfully'], 201);
    }

    public function updateDelivery(Request $request, $id)
    {
        $allowedStatuses = ['scheduled', 'in_transit', 'delivered', 'cancelled'];

        // Guard Clauses
        if ($request->has('status') && !in_array($request->input('status'), $allowedStatuses)) {
            return response()->json([
                'status' => 422,
                'error' => 'status must be one of: scheduled, in_transit, delivered, cancelled',
                'field' => 'status'
            ], 422);
        }

        return response()->json(['message' => 'Delivery updated successfully', 'id' => $id], 200);
    }

    // Task 4: Sensitive Action Guard (Cancel Delivery Authorization)
    public function cancelDelivery(Request $request, $id)
    {
        if ($request->header('X-User-Role') !== 'dispatcher') {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: Only dispatchers can cancel deliveries',
                'field' => 'authorization'
            ], 403);
        }

        return response()->json(['message' => 'Delivery status updated to cancelled', 'id' => $id], 200);
    }
}