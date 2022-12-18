<?php

namespace Usoft\Uzmobile\Resources;
use Illuminate\Http\Resources\Json\JsonResource;


class PersonalSubscriberResources extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {

        return [
//            'personalAccountCustomerId' => $this['personalAccountCustomerId'],
//            'personalAccountCustomerName' => $this['personalAccountCustomerName'],
//            'personalAccountStatus' => $this['personalAccountStatus'],
//            'accountType' => $this['accountType'],
//            'balance' => $this['balance']

        'data' => $this

        ];
    }
}
