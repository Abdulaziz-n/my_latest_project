<?php

namespace Usoft\Question\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Question\Resources\QuestionResource;

class QuestionApiResource extends JsonResource
{
    public static $wrap = false;


    public function toArray($request)
    {
        return [
          'questions' => $this->questions
        ];
    }
}
