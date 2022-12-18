<?php

namespace Usoft\Social\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialRequest extends FormRequest
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
            'title' => 'required|string',
            'type' => 'required|string',
            'url' => 'required|string',
            'position' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute must be of a type string ',
            'integer' => 'The :attribute must be of a type integer ',
            'required' => 'The :attribute must be a required',
        ];

    }


}
