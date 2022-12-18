<?php

namespace Usoft\Uzmobile\Services;

use Illuminate\Support\Str;
use Usoft\RabbitMq\Services\SendService;

class SetByUserService
{

    public function sendQueue($step, $userSubscriber, $type, $hash, $type_package = null)
    {
        if ($type == 'premium') {

            $attributes = [
                'step' => $step,
                'language' => $userSubscriber->language,
                'user' => $userSubscriber,
                'type' => $type_package,
                'hash' => $hash
            ];

            try {
                switch ($step) {
                    case 2:
                        (new SendService())->queue_declare('premium_double', $attributes);
                        break;
                    case 3:
                        (new SendService())->queue_declare('premium_triple', $attributes);
                        break;
                    default:
                        (new SendService())->queue_declare('premium', $attributes);
                        break;
                }
            } catch (\Exception $exception) {
                \Illuminate\Support\Facades\Log::error("Rabbit send Premium {$step} {$exception->getMessage()}");
            }
        } else {

            $attributes = [
                'step' => $step,
                'language' => $userSubscriber->language,
                'user' => $userSubscriber,
                'ads' => false,
                'hash' => $hash
            ];

            try {
                switch ($step) {
                    case 2:
                        (new SendService())->queue_declare('daily_double', $attributes);
                        break;
                    case 3:
                        (new SendService())->queue_declare('daily_triple', $attributes);
                        break;
                    default:
                        (new SendService())->queue_declare('daily', $attributes);
                        break;
                }
            } catch (\Exception $exception) {
                \Illuminate\Support\Facades\Log::error("Rabbit send Daily {$step} {$exception->getMessage()}");
            }
        }

        return response([
            'message' => 'Your request is being processed'
        ]);

    }

}
