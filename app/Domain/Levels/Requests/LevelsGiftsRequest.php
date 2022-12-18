<?php

namespace Usoft\Levels\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelsGiftsRequest extends FormRequest
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'type' => 'required|string|in:internet,sms,voice,prize,paynet',
            'amount' => 'integer',
            'package_id' => 'integer',
            'published' => 'boolean',
            'count' => 'integer',
            'image' => 'image|mimes:jpeg,png,jpg,webp',
            'position' => 'integer',
            'count_draft' => 'integer',
            'probability' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute must be of a type string ',
            'integer' => 'The :attribute must be of a type integer ',
            'array' => 'The :attribute must be of a type array ',
            'required' => 'The :attribute must be a required',
            'boolean' => 'The :attribute must be of a type boolean',
            'in'  => 'The :attribute must be one of the following types: :values'
        ];

    }
}
