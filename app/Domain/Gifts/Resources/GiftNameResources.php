<?php

namespace Usoft\Gifts\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GiftNameResources extends JsonResource
{

    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'uz' => $this['uz'],
            'en' => $this['en'],
            'ru' => $this['ru'],
        ];
    }

}
