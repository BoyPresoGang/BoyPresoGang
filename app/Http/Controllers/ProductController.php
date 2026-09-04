<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        // Guard Clauses
        if (!$request->has('name') || empty(trim($request->input('name')))) {
            return response()->json(['error' => 'Product name is required'], 422);
        }

        if (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 150) {
            return response()->json(['error' => 'Product name must be between 2 and 150 characters'], 422);
        }

        if (!$request->has('price') || !is_numeric($request->input('price')) || $request->input('price') <= 0) {
            return response()->json(['error' => 'Price must be a number greater than 0'], 422);
        }

        if (!$request->has('stock') || !is_numeric($request->input('stock')) || $request->input('stock') < 0) {
            return response()->json(['error' => 'Stock must be an integer 0 or greater'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Product validation passed'], 201);
    }

    public function updateProduct(Request $request, $id)
    {
        // Guard Clauses
        if ($request->has('name') && (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 150)) {
            return response()->json(['error' => 'Product name must be between 2 and 150 characters'], 422);
        }

        if ($request->has('price') && (!is_numeric($request->input('price')) || $request->input('price') <= 0)) {
            return response()->json(['error' => 'Price must be a number greater than 0'], 422);
        }

        if ($request->has('stock') && (!is_numeric($request->input('stock')) || $request->input('stock') < 0)) {
            return response()->json(['error' => 'Stock must be an integer 0 or greater'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Product update validation passed', 'id' => $id], 200);
    }
}