<?php

namespace Usoft\Gifts\Resources;

use App\Http\Resources\NameResources;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftResources extends JsonResource
{
    public static $wrap = false;


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => new NameResources($this->name),
            'package_id' => $this->package_id,
            'published' => $this->published,
            'first_prize' => $this->first_prize,
            'super_prize' => $this->super_prize,
            'type' => $this->type,
            'premium' => $this->premium,
            'sticker_id' => $this->sticker_id,
            'values' => $this->values,
            'price' => $this->price,
            'created_at' => $this->created_at
        ];
    }
}
