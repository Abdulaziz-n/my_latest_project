<?php

namespace App\Domain\Gifts\Resources;

use App\Http\Resources\NameResources;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Gifts\Resources\GiftResources;

class GiftsFilterFieldsResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'gifts' =>   GiftFilterResources::collection($this)->all(),
            'steps' => [1,2,3]
        ];
    }
}
