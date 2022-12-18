<?php

namespace Usoft\UserSubscribers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriberStatisticsResource extends JsonResource
{
    public static $wrap = false;


    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'app_count' => $this->count,
            'tg_count' => $this->tg_count
        ];
    }
}
