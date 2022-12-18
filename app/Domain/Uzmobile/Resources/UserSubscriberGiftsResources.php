<?php

namespace Usoft\Uzmobile\Resources;

use http\Env\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\Gifts\Models\Gift;
use Usoft\Gifts\Resources\GiftResources;

class UserSubscriberGiftsResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {

        return [
            'gifts' =>   GiftResources::collection($this)->all(),
                'types' => [
                    [
                        'name' => "daily",
                        'type' => 'daily'
                    ],
                    [
                        'name' => "premium",
                        'type' => 'premium'
                    ],
                ],
                'steps' => [1,2,3],

        ];
    }
}
