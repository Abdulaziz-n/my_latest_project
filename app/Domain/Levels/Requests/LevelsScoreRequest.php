<?php

namespace Usoft\Levels\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelsScoreRequest extends FormRequest
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
            'step' => 'required|integer',
            'score' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'integer' => 'The :attribute must be of a type integer ',
        ];

    }
}
