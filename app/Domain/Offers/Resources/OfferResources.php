<?php

namespace Usoft\Offers\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'offer_id' => $this->offer_id,
          'types' => $this->types
        ];
    }
}
