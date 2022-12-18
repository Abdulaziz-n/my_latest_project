<?php

namespace Usoft\Answer\Resources;

use App\Http\Resources\Question\QuestionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
          'position' => $this->position
        ];
    }
}
