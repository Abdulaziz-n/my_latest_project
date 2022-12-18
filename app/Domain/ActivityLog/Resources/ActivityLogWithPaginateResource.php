<?php

namespace Usoft\ActivityLog\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\ActivityLog\Resources\ActivityLogResources;
use Illuminate\Pagination\AbstractPaginator;

class ActivityLogWithPaginateResource extends JsonResource
{

    public static $wrap = false;

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [

            'items' => ActivityLogResources::collection($this->items())->all(),

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
