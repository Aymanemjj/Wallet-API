<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAction extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|gt:0',
            'description' => 'string',

        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Amount is a required input.',
            'amount.numeric' => 'Amount needs to be numeric.',
            'amount.gt'=>'Le montant doit être supérieur à 0',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Erreur de validation',
            'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
