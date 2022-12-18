<?php

namespace App\Domain\Policy\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class PolicyResource extends JsonResource
{
    public static  $wrap = false;


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content
        ];
    }
}
