<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

abstract class Controller
{
    protected function validateRequest(array $data, array $rules, array $messages = [])
    {
        $validator = Validator::make($data, $rules, $messages);

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
}
