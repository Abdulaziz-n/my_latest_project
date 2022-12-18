<?php

namespace Usoft\Organization\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            'name' => 'string',
            'uuid' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
          'string' => 'The :attribute must be exactly :string'
        ];
    }
}
