<?php

namespace Usoft\Levels\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Levels\Models\LevelsGift;
use Usoft\Levels\Resources\LevelsGiftsResources;
use Usoft\Levels\Resources\LevelsResources;
use Usoft\UserSubscribers\Resources\UserSubscribersResource;

class LevelsUserResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => UserSubscribersResource::make($this->whenLoaded('user')),
            'level' => LevelsResources::make($this->whenLoaded('level')),
            'gifts' => LevelsGiftsSingleResources::make($this->whenLoaded('levelGift')),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
