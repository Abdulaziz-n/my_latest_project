<?php

namespace Usoft\ActivityLog\Resources;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Usoft\UserSubscribers\Resources\UserSubscribersResource;

class ActivityLogResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => UserSubscribersResource::make($this->whenLoaded('user')),
            'phone' => $this->phone,
            'action' => $this->action,
            'data' => $this->data,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
