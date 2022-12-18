<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string',
            'role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The field name must be a required',
            'name.string' => 'The field name must be a type of string',
            'email.required' => 'The email must be a required',
            'email.unique' => 'The email must be a unique, this email is exists',
            'password.string' => 'The field password must be a type of string',
            'role_id.required ' => 'The field role id must be a required',
        ];
    }
}
