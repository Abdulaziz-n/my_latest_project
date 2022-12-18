<?php

namespace Usoft\Policy\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PolicyRequest extends FormRequest
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
            'name*' => 'array',
            'name.*' => 'string',
            'content*' => 'array',
            'content.*' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute must be of a type string ',
            'array' => 'The :attribute must be of a type array ',
        ];

    }
}
