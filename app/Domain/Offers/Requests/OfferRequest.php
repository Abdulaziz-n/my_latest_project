<?php

namespace Usoft\Offers\Requests;

use Illuminate\Foundation\Http\FormRequest;


class OfferRequest extends FormRequest
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
            'offer_id' => 'required|integer',
            'types*' => 'array',
            'types.*' => 'string|in:internet,sms,voice'
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute must be of a type string ',
            'integer' => 'The :attribute must be of a type integer ',
            'array' => 'The :attribute must be of a type array ',
            'required' => 'The :attribute must be a required',
            'in'  => 'The :attribute must be one of the following types: :values'
        ];

    }
}
