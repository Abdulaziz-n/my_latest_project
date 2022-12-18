<?php

namespace Usoft\Levels\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelsScoreResources extends JsonResource
{
    public static $wrap = false;


    public function toArray($request)
    {
        return [
          'id' => $this->id,
            'score' => $this->score,
            'step' => $this->step,
            'level' => LevelsResources::make($this->level),

        ];
    }
}
