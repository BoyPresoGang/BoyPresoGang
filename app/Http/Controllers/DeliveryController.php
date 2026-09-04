<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    protected const ALLOWED_STATUSES = ['scheduled', 'in_transit', 'delivered', 'cancelled'];

    /**
     * Shared validation rules, reused across create/update.
     */
    protected function rules(bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';
        $statuses = implode(',', self::ALLOWED_STATUSES);

        return [
            'customer_id' => "{$required}|integer",
            'delivery_date' => "{$required}|date",
            'status' => "{$required}|in:{$statuses}",
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

    public function createDelivery(Request $request)
    {
        $result = $this->validateOrFail($request);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $delivery = Delivery::create($result);

        return response()->json([
            'status' => 201,
            'data' => $delivery,
        ], 201);
    }

    public function showDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);

        return response()->json([
            'status' => 200,
            'data' => $delivery,
        ], 200);
    }

    public function updateDelivery(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);

        $result = $this->validateOrFail($request, isUpdate: true);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $delivery->update($result);

        return response()->json([
            'status' => 200,
            'data' => $delivery,
        ], 200);
    }

    public function deleteDelivery(Request $request, $id)
    {
        if ($request->header('X-User-Role') !== 'dispatcher') {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: Only dispatchers can cancel deliveries',
                'field' => 'authorization',
            ], 403);
        }

        $delivery = Delivery::findOrFail($id);
        $delivery->update(['status' => 'cancelled']);

        return response()->json([
            'status' => 200,
            'message' => 'Delivery status updated to cancelled',
            'data' => $delivery,
        ], 200);
    }
}