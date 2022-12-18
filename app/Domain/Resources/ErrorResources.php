<?php

namespace Usoft\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
          'code' => $this->getCode(),
          'message' => $this->getMessage(),
        ];
    }
}
