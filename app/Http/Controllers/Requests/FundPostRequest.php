<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FundPostRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'fund.required'    => 'Fund name is required',
            'manager.required' => 'Manager name is required',
            'year.required'    => 'Year is required',

        ];
    }
    public function rules(): array
    {
        return [
            'fund'    => 'required|string|max:255',
            'manager' => 'required|string|max:255',
            'year'    => 'required|numeric'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'success'   => false,
                'error'     => $validator->errors(),
            ]
        ));
    }
}


