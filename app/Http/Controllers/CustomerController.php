<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Shared validation rules, reused across store/update.
     */
    protected function rules(bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return [
            'name' => "{$required}|string|min:2|max:100",
            'contact_number' => "{$required}|string|min:7|max:20",
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

    public function createCustomer(Request $request)
    {
        $result = $this->validateOrFail($request);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $customer = Customer::create($result);

        return response()->json([
            'status' => 201,
            'data' => $customer,
        ], 201);
    }

    public function showCustomer($id)
    {
        $customer = Customer::findOrFail($id);

        return response()->json([
            'status' => 200,
            'data' => $customer,
        ], 200);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $result = $this->validateOrFail($request, isUpdate: true);

        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result; // validation failed
        }

        $customer->update($result);

        return response()->json([
            'status' => 200,
            'data' => $customer,
        ], 200);
    }

    public function deleteCustomer(Request $request, $id)
    {
        if ($request->header('X-User-Role') !== 'admin') {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden: Only admins can delete customers',
                'field' => 'authorization',
            ], 403);
        }

        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Customer deleted successfully',
            'id' => $id,
        ], 200);
    }
}