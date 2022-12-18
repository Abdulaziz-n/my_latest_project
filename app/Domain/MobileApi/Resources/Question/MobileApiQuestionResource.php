<?php

namespace Usoft\MobileApi\Resources\Question;

use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Question\Resources\QuestionResource;

class MobileApiQuestionResource extends JsonResource
{
    public static $wrap = false;


    public function toArray($request)
    {
        return [
          'questions' => $this->whenLoaded('questions', MobileQuestionResource::collection($this->questions)->all())
        ];
    }
}
