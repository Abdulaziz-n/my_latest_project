<?php

namespace App\Domain\UsersGifts\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\UsersGifts\Models\UsersGift;
use Usoft\UsersGifts\Resources\UsersGiftsStatisticsResources;

class UsersGiftsStatisticsWithTotalResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        $total = UsersGift::query()->whereBetween('created_at', [Carbon::today()->subDays(30), Carbon::today()])->count();

        return [
          'items' => UsersGiftsStatisticsResources::collection($this)->all(),
          'total' => $total
        ];
    }
}
