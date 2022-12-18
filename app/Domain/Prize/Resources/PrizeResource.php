<?php

namespace Usoft\Prize\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrizeResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name'=>[
              'uz' =>  'Prize uz',
              'ru' =>  'Prize ru',
              'en' =>  'Prize en',
            ],
            'content' => [
                'uz' => $this->content_ru,
                'ru' => $this->content_ru,
                'en' => $this->content_en,
            ],


        ];
    }

}
