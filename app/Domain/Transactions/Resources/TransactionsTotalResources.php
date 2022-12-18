<?php

namespace Usoft\Transactions\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsTotalResources extends JsonResource
{

    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,

        ];
    }
}
