<?php

namespace Usoft\UserSubscribers\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Usoft\ActivityLog\Resources\ActivityLogResources;

class UserSubscribersResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        if ($this->verified == false){
            $stop = true;
        }else
            $stop = $this->stop;
        return [
            'id' => $this->id,
            'phone' => $this->phone,
//            'verify_code' => $this->verify_code,
            'verified' => $this->verified,
            'stop' => $stop,
            'business' => $this->business,
//            'first_prize' => $this->first_prize,
//            'prize' => $this->prize,
            'language' => $this->language,
            'company' => $this->company,
//            'logs' => $this->log,
//            'subscriber_id' => $this->subscriber_id,
//            'personal_accountCustomer_id' => $this->personal_accountCustomer_id,
//            'rate_plan_id' => $this->rate_plan_id
        ];
    }
}
