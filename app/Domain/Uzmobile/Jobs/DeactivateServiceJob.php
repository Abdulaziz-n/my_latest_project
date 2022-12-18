<?php

namespace Usoft\Uzmobile\Jobs;

use App\Policies\ActivePackPolicy;
use App\Services\InformationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\UserSubscribers\Models\UserSubscriber;

class DeactivateServiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userSubscriber;

    public function __construct($userSubscriber)
    {
        $this->userSubscriber = $userSubscriber;
    }

    public function handle()
    {

        $this->userSubscriber->update([
            'stop' => true
        ]);

        try {
            $deactivate = (new InformationService())->deactivateService($this->userSubscriber->subscriber_id);
//            return $deactivate;
        } catch (\Exception $exception) {

            return $exception->getMessage();
        }

        return response('', 204);
    }
}
