<?php

namespace Usoft\Question\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        if ($this->question){
            return [
                'name' => 'array',
                'name.*' => 'string',
                'hint' => 'array',
                'hint.*' => 'string',
                'survey_id' => 'integer',
                'award_coins' => 'integer',
                'position' => 'integer',
                'input_type_id' => 'integer',
                'is_draft' => 'boolean',
                'is_multiple' => 'boolean',
                'is_required' => 'boolean',
                'timer' => 'integer'
            ];
        }

    }

//    public function messages()
//    {
//        return [
//            'boolean' => 'The :attribute must be of type boolean',
//            'array' => 'The :attribute must be of type array',
//            'string' => 'The :attribute must be of type string',
//            'integer' => 'The :attribute must be of type integer',
//        ];
//    }
}
