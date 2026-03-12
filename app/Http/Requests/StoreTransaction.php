<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTransaction extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|gt:0',
            'receiver_wallet_id' => 'required|int',
            'description' => 'string',

        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Amount is a required input.',
            'amount.numeric' => 'Amount needs to be numeric.',
            'amount.gt'=>'Le montant doit être supérieur à 0',

            'sender_wallet_id.exists' => "Source wallet doesn't exist.",
            'sender_wallet_id.int' => 'Source wallet needs to be and integer.',

            'receiver_wallet_id.exists' => "target wallet doesn't exist.",
            'receiver_wallet_id.int' => 'target wallet needs to be and integer.',

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
