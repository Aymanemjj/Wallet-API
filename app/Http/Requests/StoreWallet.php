<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreWallet extends FormRequest
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
            'name' => 'required|max:255|string',
            'currency' => 'required|max:255|string',
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'Title is a required input.',
            'name.max' => 'Title needs to be less than 255 charachters.',

            'currency.required' => 'Lastname is a required input.',
            'currency.max' => 'Lastname needs to be less than 255 charachters.',

        ];
    }

     public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            "success"=> false,
            'message' => 'Erreur de validation',
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    } 
}
