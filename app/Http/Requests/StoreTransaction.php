<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'amount' => 'required|numeric',
            'origin_wallet_id' => 'required|int|exists:wallets,id',
            'destination_wallet_id' => 'required|int|exists:wallets,id',
        ];
    }

    public function message()
    {
        return [
            'amount.required' => 'Amount is a required input.',
            'amount.numeric' => 'Amount needs to be numeric.',

            'origin_wallet_id.required' => 'Source wallet is a required input.',
            'origin_wallet_id.int' => 'Source wallet needs to be and integer.',

            'destination_wallet_id.required' => 'Source wallet is a required input.',
            'destination_wallet_id.int' => 'Source wallet needs to be and integer.',

        ];
    }
}
