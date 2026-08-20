<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function listCustomers() { return response()->json(['message' => 'listCustomers stub'], 200); }
    public function createCustomer(Request $request) { return response()->json(['message' => 'createCustomer stub'], 201); }
    public function showCustomer(string $id) { return response()->json(['message' => 'showCustomer stub', 'id' => $id], 200); }
    public function updateCustomer(Request $request, string $id) { return response()->json(['message' => 'updateCustomer stub', 'id' => $id], 200); }
    public function deleteCustomer(string $id) { return response()->json(['message' => 'deleteCustomer stub', 'id' => $id], 200); }
}