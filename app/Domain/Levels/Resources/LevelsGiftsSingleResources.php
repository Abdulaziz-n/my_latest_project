<?php

namespace Usoft\Levels\Resources;

use App\Http\Resources\NameResources;
use Illuminate\Http\Resources\Json\JsonResource;


class LevelsGiftsSingleResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => new NameResources($this->name),
            'type' => $this->type,
            'level' => LevelsResources::make($this->level),
        ];
    }
}
