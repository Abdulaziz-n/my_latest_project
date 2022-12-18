<?php

namespace Usoft\UserSubscribers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\UserSubscribers\Resources\UserSubscribersResource;


class UserSubscribersPaginateResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'items'=> UserSubscribersResource::collection($this->items())->all(),

            'pagination' => [
                'current' => $this->currentPage(),
                'previous' => $this->currentPage() > 1 ? $this->currentPage() -1 : null,
                'next' => $this->hasMorePages() ? $this->currentPage() + 1 : null,
                'total' => $this->lastPage(),
                'perPage' => $this->perPage(),
                'totalItems' => $this->total()
            ],
        ];
    }
}
