<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NameResources extends JsonResource
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
            'uz' => $this['uz'] ?? null,
            'en' => $this['en'] ?? null,
            'ru' => $this['ru'] ?? null,
        ];
    }
}
