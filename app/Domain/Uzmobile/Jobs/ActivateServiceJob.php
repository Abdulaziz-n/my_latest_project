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
use Illuminate\Support\Facades\Log;
use Usoft\UserSubscribers\Models\UserSubscriber;


class ActivateServiceJob implements ShouldQueue
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
            'stop' => false
        ]);
        Log::info('Subscriber_____PHONE : ' . $this->userSubscriber->phone);
        Log::info('STOP______ ' . $this->userSubscriber->stop);

        try {
            $deactivate = (new InformationService())->activateService($this->userSubscriber->subscriber_id);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return response()->json('', 204);
    }
}
