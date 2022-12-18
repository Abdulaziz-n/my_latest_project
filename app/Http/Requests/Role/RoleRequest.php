<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        if ($this->isMethod('get')) return [];

        return [
            'name' => 'required|string',
            'permission' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The field name must be a required',
            'permission.required' => 'The field permission must be a required',
        ];

    }
}
