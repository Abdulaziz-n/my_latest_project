<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Usoft\TGSubscriber\Models\TelegramSubscriber;
use Usoft\UserSubscribers\Models\UserSubscriber;
use Usoft\UserSubscribers\Models\UserSubscriberStatistic;
use Carbon\Carbon;

class SubscriberStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriber:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dates = [];
        for ($i = 0; $i <= 30; $i++) {
            $users = UserSubscriber::query()->whereBetween('created_at', [Carbon::today()->subDays($i)->startOfDay(), Carbon::today()->subDays($i)->endOfDay()])->get();

            $tg_count = TelegramSubscriber::query()->whereBetween('created_at', [Carbon::today()->subDays($i)->startOfDay(), Carbon::today()->subDays($i)->endOfDay()])->get();

            $dates[] = [
                'count' => count($users),
                'tg_count' => count($tg_count),
                'date' => Carbon::today()->subDays($i)->format('Y-m-d')
            ];

        }

        foreach ($dates as $date){
            UserSubscriberStatistic::updateOrCreate([
                'date' => $date['date']
            ],[
                'count' => $date['count'],
                'tg_count' => $date['tg_count']
            ]);
        }
    }
}
