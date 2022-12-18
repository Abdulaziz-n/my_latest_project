<?php

namespace Usoft\Guide\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuideRequest extends FormRequest
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
            'title' => 'required|array',
            'title.*' => 'string',
            'body' => 'array',
            'body.*' => 'string',
            'position' => 'integer',
            'image' => 'nullable|mimes:png,jpeg,webp,jpg,'
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute must be of a type string ',
            'integer' => 'The :attribute must be of a type integer ',
            'required' => 'The :attribute must be a required',
            'mimes' => 'The :attribute must be of type a jpeg, webp, jpg, png',

        ];

    }

}
