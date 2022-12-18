<?php

namespace Usoft\Guide\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GuideResources extends JsonResource
{
    public static $wrap = false;


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'position' => $this->position
        ];
    }
}
