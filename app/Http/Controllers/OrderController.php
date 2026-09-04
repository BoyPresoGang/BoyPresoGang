<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        // Guard Clauses
        if (!$request->has('customer_id') || !is_numeric($request->input('customer_id'))) {
            return response()->json(['error' => 'customer_id is required and must be an integer'], 422);
        }

        if (!$request->has('product_id') || !is_numeric($request->input('product_id'))) {
            return response()->json(['error' => 'product_id is required and must be an integer'], 422);
        }

        if (!$request->has('quantity') || !is_numeric($request->input('quantity')) || $request->input('quantity') < 1) {
            return response()->json(['error' => 'quantity must be an integer greater than 0'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Order validation passed'], 201);
    }

    public function updateOrder(Request $request, $id)
    {
        // Guard Clauses
        if ($request->has('customer_id') && !is_numeric($request->input('customer_id'))) {
            return response()->json(['error' => 'customer_id must be an integer'], 422);
        }

        if ($request->has('product_id') && !is_numeric($request->input('product_id'))) {
            return response()->json(['error' => 'product_id must be an integer'], 422);
        }

        if ($request->has('quantity') && (!is_numeric($request->input('quantity')) || $request->input('quantity') < 1)) {
            return response()->json(['error' => 'quantity must be an integer greater than 0'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Order update validation passed', 'id' => $id], 200);
    }
}