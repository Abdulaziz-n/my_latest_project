<?php

namespace Usoft\Categories\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Gifts\Resources\GiftResources;

class CategoryResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'packages' => $this->packages,
            'gifts' =>  GiftResources::collection($this->gifts),
            'step' => $this->step,
            'last_package_id' => $this->last_package_id
        ];
    }

}
