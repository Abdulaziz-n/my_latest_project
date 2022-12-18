<?php

namespace Usoft\Question\Resources;

use Usoft\Answer\Resources\AnswerResource;
use Usoft\InputType\Resources\InputTypeResource;
use Usoft\Survey\Resources\SurveyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'hint' => $this->hint,
            'award_coins' => $this->award_coins,
            'position' => $this->position,
            'input_type' => $this->whenLoaded('inputType', new InputTypeResource($this->inputType)),
            'is_draft' => $this->is_draft,
            'is_multiple' => $this->is_multiple,
            'is_required' => $this->is_required,
            'timer' => $this->timer,
            'answers' => $this->whenLoaded('answers', AnswerResource::collection($this->answers))
        ];

    }
}
