<?php

namespace Usoft\Prize\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PrizeRequest extends FormRequest
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
            'content_uz' => 'required|string',
            'content_ru' => 'required|string',
            'content_en' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute must be a required',
            'string' => 'The :attribute must be of a type string ',
        ];

    }

}
