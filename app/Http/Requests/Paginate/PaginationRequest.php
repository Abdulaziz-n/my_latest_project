<?php

namespace App\Http\Requests\Paginate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginationRequest extends FormRequest
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
        return [
            'perPage' => [
                'integer',
                Rule::in(['10', '20', '30', '50', '100'])],
        ];
    }


    public function messages()
    {
        return [
            'in'  => 'The :attribute must be one of the following types: :values'
        ];
    }
}
