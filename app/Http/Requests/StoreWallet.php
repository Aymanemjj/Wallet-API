<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWallet extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255|string',
            'currency' => 'required|max:255|string',
            'password' => 'required|max:255',
            'user_id' => 'required|int|exists:users,id',

        ];
    }

    public function message()
    {
        return [
            'title.required' => 'Title is a required input.',
            'title.max' => 'Title needs to be less than 255 charachters.',

            'currency.required' => 'Lastname is a required input.',
            'currency.max' => 'Lastname needs to be less than 255 charachters.',

            'user_id.exists' => 'This user_id is is not real',
            'user_id.required' => 'User_id is a required input.',
            'user_id.int' => 'User_id needs to be an integer.',

            'password.required' => 'Password is a required input.',
            'password.max' => 'Password needs to be less than 255 charachters.',

        ];
    }
}
