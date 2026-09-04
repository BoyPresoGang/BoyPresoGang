<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        // Guard Clauses (Task 2 & 3)
        if (!$request->has('customer_id') || !is_numeric($request->input('customer_id'))) {
            return response()->json([
                'status' => 422,
                'error' => 'customer_id is required and must be an integer',
                'field' => 'customer_id'
            ], 422);
        }

        if (!$request->has('product_id') || !is_numeric($request->input('product_id'))) {
            return response()->json([
                'status' => 422,
                'error' => 'product_id is required and must be an integer',
                'field' => 'product_id'
            ], 422);
        }

        if (!$request->has('quantity') || !is_numeric($request->input('quantity')) || $request->input('quantity') < 1) {
            return response()->json([
                'status' => 422,
                'error' => 'quantity must be an integer greater than 0',
                'field' => 'quantity'
            ], 422);
        }

        return response()->json(['message' => 'Order created successfully'], 201);
    }

    public function updateOrder(Request $request, $id)
    {
        // Guard Clauses
        if ($request->has('quantity') && (!is_numeric($request->input('quantity')) || $request->input('quantity') < 1)) {
            return response()->json([
                'status' => 422,
                'error' => 'quantity must be an integer greater than 0',
                'field' => 'quantity'
            ], 422);
        }

        return response()->json(['message' => 'Order updated successfully', 'id' => $id], 200);
    }

    // Task 4: Sensitive Action Guard (Cancel / Edit Order Ownership Check)
    public function cancelOrder(Request $request, $id)
    {
        $currentUserId = $request->header('X-User-Id');
        $orderOwnerId = '100'; // Simulated order owner ID

        if ($currentUserId !== $orderOwnerId) {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: You can only cancel your own orders',
                'field' => 'authorization'
            ], 403);
        }

        return response()->json(['message' => 'Order cancelled successfully', 'id' => $id], 200);
    }
}