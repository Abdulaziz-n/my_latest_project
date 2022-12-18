<?php

namespace Usoft\Levels\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelsUsersPaginateResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [

            'items' => LevelsUserResources::collection($this->items())->all(),

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
