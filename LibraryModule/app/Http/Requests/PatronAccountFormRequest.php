<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatronAccountFormRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:patron_account',
            'id_number' => 'required|string',
            'password' => 'required|string',
            'confirm_password' => 'required|string',
        ];
    }
}
