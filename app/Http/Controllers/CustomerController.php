<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function createCustomer(Request $request)
    {
        // Guard Clauses
        if (!$request->has('name') || empty(trim($request->input('name')))) {
            return response()->json(['error' => 'Customer name is required'], 422);
        }

        if (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 100) {
            return response()->json(['error' => 'Customer name must be between 2 and 100 characters'], 422);
        }

        if (!$request->has('contact_number') || empty(trim($request->input('contact_number')))) {
            return response()->json(['error' => 'Contact number is required'], 422);
        }

        if (strlen($request->input('contact_number')) < 7 || strlen($request->input('contact_number')) > 20) {
            return response()->json(['error' => 'Contact number must be between 7 and 20 characters'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Customer validation passed'], 201);
    }

    public function updateCustomer(Request $request, $id)
    {
        // Guard Clauses
        if ($request->has('name') && (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 100)) {
            return response()->json(['error' => 'Customer name must be between 2 and 100 characters'], 422);
        }

        if ($request->has('contact_number') && (strlen($request->input('contact_number')) < 7 || strlen($request->input('contact_number')) > 20)) {
            return response()->json(['error' => 'Contact number must be between 7 and 20 characters'], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Customer update validation passed', 'id' => $id], 200);
    }
}