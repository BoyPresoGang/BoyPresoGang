<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        // Guard Clauses (Task 2 & 3)
        if (!$request->has('name') || empty(trim($request->input('name')))) {
            return response()->json([
                'status' => 422,
                'error' => 'Product name is required',
                'field' => 'name'
            ], 422);
        }

        if (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 150) {
            return response()->json([
                'status' => 422,
                'error' => 'Product name must be between 2 and 150 characters',
                'field' => 'name'
            ], 422);
        }

        if (!$request->has('price') || !is_numeric($request->input('price')) || $request->input('price') <= 0) {
            return response()->json([
                'status' => 422,
                'error' => 'Price must be a number greater than 0',
                'field' => 'price'
            ], 422);
        }

        if (!$request->has('stock') || !is_numeric($request->input('stock')) || $request->input('stock') < 0) {
            return response()->json([
                'status' => 422,
                'error' => 'Stock must be an integer 0 or greater',
                'field' => 'stock'
            ], 422);
        }

        return response()->json(['message' => 'Product created successfully'], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        // Guard Clauses
        if ($request->has('name') && (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 150)) {
            return response()->json([
                'status' => 422,
                'error' => 'Product name must be between 2 and 150 characters',
                'field' => 'name'
            ], 422);
        }

        if ($request->has('price') && (!is_numeric($request->input('price')) || $request->input('price') <= 0)) {
            return response()->json([
                'status' => 422,
                'error' => 'Price must be a number greater than 0',
                'field' => 'price'
            ], 422);
        }

        if ($request->has('stock') && (!is_numeric($request->input('stock')) || $request->input('stock') < 0)) {
            return response()->json([
                'status' => 422,
                'error' => 'Stock must be an integer 0 or greater',
                'field' => 'stock'
            ], 422);
        }

        return response()->json(['message' => 'Product updated successfully', 'id' => $id], 200);
    }

    // Task 4: Sensitive Action Guard (Delete Product)
    public function deleteProduct(Request $request, $id)
    {
        if ($request->header('X-User-Role') !== 'manager') {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: Only managers can delete products',
                'field' => 'authorization'
            ], 403);
        }

        return response()->json(['message' => 'Product deleted successfully', 'id' => $id], 200);
    }
}