<?php

namespace Usoft\UsersGifts\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Gifts\Resources\GiftResources;
use Usoft\UserSubscribers\Resources\UserSubscribersResource;


class UsersGiftsResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'game' => $this->game,
            'premium' => $this->premium,
            'step' => $this->step,
            'price' => $this->price,
            'gift' => GiftResources::make($this->whenLoaded('gift')),
            'user' => UserSubscribersResource::make($this->whenLoaded('subscriber')),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:m:s')
        ];
    }
}
