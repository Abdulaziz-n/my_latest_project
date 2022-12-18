<?php

namespace App\Domain\Gifts\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GiftFilterResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'premium' => $this->premium
        ];
    }
}
