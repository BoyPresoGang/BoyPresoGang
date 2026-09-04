<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function createCustomer(Request $request)
    {
        // Guard Clauses (Task 2 & Task 3: Standardized error shape)
        if (!$request->has('name') || empty(trim($request->input('name')))) {
            return response()->json([
                'status' => 422,
                'error' => 'Customer name is required',
                'field' => 'name'
            ], 422);
        }

        if (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 100) {
            return response()->json([
                'status' => 422,
                'error' => 'Customer name must be between 2 and 100 characters',
                'field' => 'name'
            ], 422);
        }

        if (!$request->has('contact_number') || empty(trim($request->input('contact_number')))) {
            return response()->json([
                'status' => 422,
                'error' => 'Contact number is required',
                'field' => 'contact_number'
            ], 422);
        }

        if (strlen($request->input('contact_number')) < 7 || strlen($request->input('contact_number')) > 20) {
            return response()->json([
                'status' => 422,
                'error' => 'Contact number must be between 7 and 20 characters',
                'field' => 'contact_number'
            ], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Customer validation passed'], 201);
    }

    public function updateCustomer(Request $request, $id)
    {
        // Guard Clauses
        if ($request->has('name') && (strlen($request->input('name')) < 2 || strlen($request->input('name')) > 100)) {
            return response()->json([
                'status' => 422,
                'error' => 'Customer name must be between 2 and 100 characters',
                'field' => 'name'
            ], 422);
        }

        if ($request->has('contact_number') && (strlen($request->input('contact_number')) < 7 || strlen($request->input('contact_number')) > 20)) {
            return response()->json([
                'status' => 422,
                'error' => 'Contact number must be between 7 and 20 characters',
                'field' => 'contact_number'
            ], 422);
        }

        // Valid data passes through
        return response()->json(['message' => 'Customer update validation passed', 'id' => $id], 200);
    }

    // Task 4: Authorization Guard (Sensitive Action)
    public function deleteCustomer(Request $request, $id)
    {
        // Example permission check using request header
        if ($request->header('X-User-Role') !== 'admin') {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: Only admins can delete customers',
                'field' => 'authorization'
            ], 403);
        }

        return response()->json(['message' => 'Customer deleted successfully', 'id' => $id], 200);
    }
}