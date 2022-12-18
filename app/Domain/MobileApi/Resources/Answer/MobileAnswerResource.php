<?php

namespace Usoft\MobileApi\Resources\Answer;

use App\Http\Resources\Question\QuestionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MobileAnswerResource extends JsonResource
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
        ];
    }
}
