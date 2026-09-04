<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Shared validation rules, reused across create/update.
     */
    protected function rules(bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return [
            'name' => "{$required}|string|min:2|max:150",
            'price' => "{$required}|numeric|gt:0",
            'stock' => "{$required}|integer|gte:0",
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

    public function createProduct(Request $request)
    {
        $result = $this->validateOrFail($request);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $product = Product::create($result);

        return response()->json([
            'status' => 201,
            'data' => $product,
        ], 201);
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'status' => 200,
            'data' => $product,
        ], 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $result = $this->validateOrFail($request, isUpdate: true);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $product->update($result);

        return response()->json([
            'status' => 200,
            'data' => $product,
        ], 200);
    }

    public function deleteProduct(Request $request, $id)
    {
        if ($request->header('X-User-Role') !== 'manager') {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: Only managers can delete products',
                'field' => 'authorization',
            ], 403);
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully',
            'id' => $id,
        ], 200);
    }
}