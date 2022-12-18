<?php

namespace Usoft\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'type' => 'string|in:daily,premium',
            'packages' => 'string|in:internet,internet_sms,voice_sms,voice,sms',
            'step' => 'integer',
            'last_package_id' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute must be a required',
            'string' => 'The :attribute must be a string',
            'integer' => 'The :attribute must be an integer',
            'in'  => 'The :attribute must be one of the following types: :values'

        ];

    }
}
