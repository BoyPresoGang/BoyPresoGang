<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'customer_id' => "{$required}|integer|exists:customers,id",
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

    protected function stockError()
    {
        return response()->json([
            'status' => 422,
            'error' => 'The requested quantity exceeds the available stock.',
            'field' => 'quantity',
        ], 422);
    }

    protected function productUnavailableError()
    {
        return response()->json([
            'status' => 422,
            'error' => 'The selected product is no longer available.',
            'field' => 'product_id',
        ], 422);
    }

    public function listOrders()
    {
        $orders = Order::all();

        return response()->json([
            'status' => 200,
            'data' => $orders,
        ], 200);
    }

    public function createOrder(Request $request)
    {
        $result = $this->validateOrFail($request);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        return DB::transaction(function () use ($result) {
            $product = Product::query()
                ->lockForUpdate()
                ->find($result['product_id']);

            if (!$product) {
                return $this->productUnavailableError();
            }

            if ($result['quantity'] > $product->stock) {
                return $this->stockError();
            }

            $product->decrement('stock', $result['quantity']);
            $order = Order::create($result);

            return response()->json([
                'status' => 201,
                'data' => $order,
            ], 201);
        });
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
        $result = $this->validateOrFail($request, isUpdate: true);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        return DB::transaction(function () use ($result, $id) {
            $order = Order::query()
                ->lockForUpdate()
                ->findOrFail($id);
            $oldProductId = (int) $order->product_id;
            $newProductId = (int) ($result['product_id'] ?? $order->product_id);
            $oldQuantity = (int) $order->quantity;
            $newQuantity = (int) ($result['quantity'] ?? $order->quantity);
            $productIds = array_values(array_unique([$oldProductId, $newProductId]));
            sort($productIds);
            $products = Product::query()
                ->whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if (!$products->has($newProductId)) {
                return $this->productUnavailableError();
            }

            $newProduct = $products->get($newProductId);

            if ($oldProductId === $newProductId) {
                $availableStock = (int) $newProduct->stock + $oldQuantity;
                if ($newQuantity > $availableStock) {
                    return $this->stockError();
                }

                $newProduct->update([
                    'stock' => $availableStock - $newQuantity,
                ]);
            } else {
                if ($newQuantity > $newProduct->stock) {
                    return $this->stockError();
                }

                $oldProduct = $products->get($oldProductId);
                if (!$oldProduct) {
                    return $this->productUnavailableError();
                }

                $oldProduct->increment('stock', $oldQuantity);
                $newProduct->decrement('stock', $newQuantity);
            }

            $order->update($result);

            return response()->json([
                'status' => 200,
                'data' => $order,
            ], 200);
        });
    }

    public function deleteOrder(Request $request, $id)
    {
        $currentUserId = $request->header('X-User-Id');

        return DB::transaction(function () use ($id, $currentUserId) {
            $order = Order::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($currentUserId === null
                || (string) $order->customer_id !== (string) $currentUserId) {
                return response()->json([
                    'status' => 403,
                    'error' => 'Forbidden: You can only cancel your own orders',
                    'field' => 'authorization',
                ], 403);
            }

            $product = Product::query()
                ->lockForUpdate()
                ->find($order->product_id);

            if (!$product) {
                return $this->productUnavailableError();
            }

            $product->increment('stock', $order->quantity);
            $order->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Order cancelled successfully',
                'id' => $id,
            ], 200);
        });
    }
}
