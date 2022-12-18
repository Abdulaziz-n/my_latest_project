<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Usoft\TGSubscriber\Models\TelegramSubscriber;
use Usoft\UserSubscribers\Models\UserSubscriber;
use Usoft\UserSubscribers\Models\UserSubscriberStatistic;

class SubscriberDailyStaticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriber:daily';

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
        ini_set('memory_limit', '1024M');


//        $dates = [];
//        for ($i = 0; $i <= 30; $i++) {
        $users = UserSubscriber::query()->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->get();
        $tg_count = TelegramSubscriber::query()->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->get();


        $data[] = [
            'count' => count($users),
            'tg_count' => count($tg_count),
            'date' => Carbon::today()->format('Y-m-d')
        ];
//        }
//        foreach ($dates as $date){
        UserSubscriberStatistic::updateOrCreate([
            'date' => Carbon::today()->format('Y-m-d')
        ], [
            'count' => $data[0]['count'],
            'tg_count' => $data[0]['tg_count']
        ]);
//        }
    }
}
