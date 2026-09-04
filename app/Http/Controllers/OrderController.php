<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Shared validation rules, reused across create/update.
     */
    protected function rules(bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return [
            'customer_id' => "{$required}|integer",
            'product_id' => "{$required}|integer",
            'quantity' => "{$required}|integer|gte:1",
        ];
    }

    /**
     * Run validation and return a standardized error response if it fails.
     */
    protected function validateOrFail(Request $request, bool $isUpdate = false)
    {
        $validator = Validator::make($request->all(), $this->rules($isUpdate));

        if ($validator->fails()) {
            $errors = $validator->errors();
            $field = array_key_first($errors->toArray());

            return response()->json([
                'status' => 422,
                'error' => $errors->first($field),
                'field' => $field,
            ], 422);
        }

        return $validator->validated();
    }

    public function createOrder(Request $request)
    {
        $result = $this->validateOrFail($request);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $order = Order::create($result);

        return response()->json([
            'status' => 201,
            'data' => $order,
        ], 201);
    }

    public function showOrder($id)
    {
        $order = Order::findOrFail($id);

        return response()->json([
            'status' => 200,
            'data' => $order,
        ], 200);
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $result = $this->validateOrFail($request, isUpdate: true);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $order->update($result);

        return response()->json([
            'status' => 200,
            'data' => $order,
        ], 200);
    }

    public function deleteOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $currentUserId = $request->header('X-User-Id');

        if ($currentUserId === null || (string) $order->customer_id !== (string) $currentUserId) {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: You can only cancel your own orders',
                'field' => 'authorization',
            ], 403);
        }

        $order->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Order cancelled successfully',
            'id' => $id,
        ], 200);
    }
}