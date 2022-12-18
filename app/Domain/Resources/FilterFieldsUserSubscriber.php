<?php

namespace App\Domain\Resources;

use App\Domain\Gifts\Resources\GiftFilterResources;
use App\Domain\Gifts\Resources\GiftsFilterFieldsResources;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\ActivityLog\Models\Log;
use Usoft\Levels\Models\Level;
use Usoft\Levels\Resources\LevelsResources;

class FilterFieldsUserSubscriber extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        $levels = Level::all();
        return [
          'transactions' => LevelsResources::collection($levels),
          'gifts' => GiftFilterResources::collection($this)->all(),
            'logs' => [
                "rub_double",
                "rub",
                "get_user_personal_info",
                "set_manual_gift",
                "subscribe_active",
                "retry_tomorrow",
                "logout",
                "rub_premium_double",
                "verify",
                "authorized",
                "try_again",
                "rub_premium",
                "no_money",
                "rub_premium_triple",
                "login",
                "rub_level_gift",
                "subscribe_stop",
                "gift_set",
                "rub_triple",
                "set_by_user",
                "paynet"
            ],
          'steps' => [1,2,3],
            'types' => ['internet','sms','voice','prize', 'paynet']
        ];
    }
}
