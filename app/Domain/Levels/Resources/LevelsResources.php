<?php

namespace Usoft\Levels\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelsResources extends JsonResource
{

    public static $wrap = false;


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'score' => $this->score
        ];
    }

}
