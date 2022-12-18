<?php

namespace Usoft\Gifts\Requests;
use Illuminate\Foundation\Http\FormRequest;

class GiftRequest extends FormRequest
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
            'package_id' => 'required|integer',
            'published' => 'boolean',
            'first_prize' => 'boolean',
            'super_prize' => 'boolean',
            'type' => 'required|string|in:internet,voice,sms',
            'sticker_id' => 'string',
            'premium' => 'boolean',
            'values' => 'integer',
            'price' => 'numeric|integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute must be a required',
            'string' => 'The :attribute must be of a type string ',
            'integer' => 'The :attribute must be of a type integer ',
            'boolean' => 'The :attribute must be of a type boolean ',
            'numeric' => 'The :attribute must be of a type numeric ',
            'array' => 'The :attribute must be of a type array ',
            'in'  => 'The :attribute must be one of the following types: :values'
        ];

    }

}
