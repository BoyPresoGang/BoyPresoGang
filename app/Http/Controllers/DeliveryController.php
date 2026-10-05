<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    protected const ALLOWED_STATUSES = ['scheduled', 'in_transit', 'delivered', 'cancelled'];
    protected const ACTIVE_STATUSES = ['scheduled', 'in_transit'];

    protected function rules(bool $isUpdate = false): array
    {
        $dateAndStatus = $isUpdate ? 'sometimes' : 'required';

        return [
            'order_id' => 'required|integer|exists:orders,id',
            'delivery_date' => $dateAndStatus . '|date|after_or_equal:today',
            'status' => $dateAndStatus . '|in:' . implode(',', self::ALLOWED_STATUSES),
        ];
    }

    protected function validateOrFail(Request $request, bool $isUpdate = false)
    {
        $validator = Validator::make($request->all(), $this->rules($isUpdate), [
            'delivery_date.after_or_equal' => 'The delivery date cannot be in the past.',
            'order_id.exists' => 'The selected order was not found.',
        ]);

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

    protected function activeDeliveryError()
    {
        return response()->json([
            'status' => 422,
            'error' => 'This order already has an active delivery.',
            'field' => 'order_id',
        ], 422);
    }

    public function listDeliveries()
    {
        return response()->json([
            'status' => 200,
            'data' => Delivery::with('order.customer', 'order.product')->get(),
        ], 200);
    }

    public function createDelivery(Request $request)
    {
        $result = $this->validateOrFail($request);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        $delivery = DB::transaction(function () use ($result) {
            $order = Order::whereKey($result['order_id'])->lockForUpdate()->first();

            if (!$order) {
                return null;
            }

            $hasActiveDelivery = Delivery::where('order_id', $order->id)
                ->whereIn('status', self::ACTIVE_STATUSES)
                ->lockForUpdate()
                ->exists();

            if ($hasActiveDelivery) {
                return false;
            }

            return Delivery::create([
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'delivery_date' => $result['delivery_date'],
                'status' => $result['status'],
            ]);
        });

        if ($delivery === false) {
            return $this->activeDeliveryError();
        }

        if ($delivery === null) {
            return response()->json([
                'status' => 422,
                'error' => 'The selected order was not found.',
                'field' => 'order_id',
            ], 422);
        }

        return response()->json([
            'status' => 201,
            'data' => $delivery->load('order.customer', 'order.product'),
        ], 201);
    }

    public function showDelivery($id)
    {
        return response()->json([
            'status' => 200,
            'data' => Delivery::with('order.customer', 'order.product')->findOrFail($id),
        ], 200);
    }

    public function updateDelivery(Request $request, $id)
    {
        $result = $this->validateOrFail($request, true);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }

        $updated = DB::transaction(function () use ($result, $id) {
            $delivery = Delivery::whereKey($id)->lockForUpdate()->first();

            if (!$delivery) {
                return null;
            }

            $order = Order::whereKey($result['order_id'])->lockForUpdate()->first();

            if (!$order) {
                return false;
            }

            $hasActiveDelivery = Delivery::where('order_id', $order->id)
                ->whereIn('status', self::ACTIVE_STATUSES)
                ->where('id', '!=', $delivery->id)
                ->lockForUpdate()
                ->exists();

            if ($hasActiveDelivery) {
                return false;
            }

            $delivery->update([
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'delivery_date' => $result['delivery_date'] ?? $delivery->delivery_date,
                'status' => $result['status'] ?? $delivery->status,
            ]);

            return $delivery;
        });

        if ($updated === null) {
            abort(404);
        }

        if ($updated === false) {
            return $this->activeDeliveryError();
        }

        return response()->json([
            'status' => 200,
            'data' => $updated->load('order.customer', 'order.product'),
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
            'data' => $delivery->load('order.customer', 'order.product'),
        ], 200);
    }
}
