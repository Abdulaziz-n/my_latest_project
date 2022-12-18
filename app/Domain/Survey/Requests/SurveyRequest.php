<?php

namespace Usoft\Survey\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
            'organization_id' => 'integer',
            'name' => 'string',
            'is_draft' => 'boolean',
            'position' => 'integer',
            'dependent_survey_id' => 'nullable',
            'is_dependent' => 'boolean'
        ];

    }

    public function messages()
    {
        return [
          'integer' => 'The :attribute must be exactly :integer',
          'unique' => 'The :attribute must be exactly :unique',
          'string' => 'The :attribute must be exactly :string',
          'boolean' => 'The :attribute must be exactly :boolean'
        ];
    }
}
