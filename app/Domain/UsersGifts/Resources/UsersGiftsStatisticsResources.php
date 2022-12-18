<?php

namespace Usoft\UsersGifts\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\UsersGifts\Models\UsersGift;

class UsersGiftsStatisticsResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {

        return [
          'date' => $this->date,
          'count' => $this->count,
        ];
    }
}
