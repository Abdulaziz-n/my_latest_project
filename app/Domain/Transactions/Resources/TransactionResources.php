<?php

namespace Usoft\Transactions\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Levels\Resources\LevelsResources;
use Usoft\UserSubscribers\Resources\UserSubscribersResource;

class TransactionResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => UserSubscribersResource::make($this->whenLoaded('user')),
            'scores' => $this->scores,
            'level' => LevelsResources::make($this->whenLoaded('level')),
            'step' => $this->step,
            'created_at' => $this->created_at->format('d-m-Y H:m:s')
        ];
    }
}
