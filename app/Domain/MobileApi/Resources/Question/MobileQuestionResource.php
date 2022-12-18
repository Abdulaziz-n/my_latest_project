<?php

namespace Usoft\MobileApi\Resources\Question;

use Usoft\Answer\Resources\AnswerResource;
use Usoft\InputType\Resources\InputTypeResource;
use Usoft\MobileApi\Resources\Answer\MobileAnswerResource;
use Usoft\MobileApi\Resources\InputType\MobileInputTypeResource;
use Usoft\Survey\Resources\SurveyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MobileQuestionResource extends JsonResource
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
            'input_type' => $this->whenLoaded('inputType', new MobileInputTypeResource($this->inputType)),
            'is_multiple' => $this->is_multiple,
            'is_required' => $this->is_required,
            'timer' => $this->timer,
            'answers' => $this->whenLoaded('answers', MobileAnswerResource::collection($this->answers))
        ];

    }
}
