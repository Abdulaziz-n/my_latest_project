<?php

namespace Usoft\Levels\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelsRequest extends FormRequest
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

    public function rules()
    {
        if ($this->isMethod('get')) return [];

        return [
            'name' => 'required|array',
            'name.*' => 'required|string',
            'score' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute must be of a type string ',
            'array' => 'The :attribute must be of a type array ',
            'integer' => 'The :attribute must be of a type integer ',
        ];

    }
}
