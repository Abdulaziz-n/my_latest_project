<?php

namespace Usoft\Levels\Resources;

use App\Http\Resources\NameResources;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelsGiftsResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => new NameResources($this->name),
            'type' => $this->type,
            'amount' => $this->amount,
            'package_id' => $this->package_id,
            'level' => LevelsResources::make($this->level),
            'published' => $this->published,
            'count' => $this->count,
            'image' => $this->getImage(),
            'position' => $this->position,
            'count_draft' => $this->count_draft,
            'probability' => $this->probability
        ];
    }


}
