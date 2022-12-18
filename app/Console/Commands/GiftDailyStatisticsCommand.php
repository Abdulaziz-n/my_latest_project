<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Usoft\Statistics\Models\GiftHistoryStatistic;
use Usoft\UsersGifts\Models\UserGiftsStatistics;
use Usoft\UsersGifts\Models\UsersGift;

class GiftDailyStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gifts:daily';

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

//        $gift = [];
//        $statistics = [];
//        for ($i = 0; $i <= 30; $i++) {

            $gifts = UsersGift::query()
                ->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
                ->get();

            $count = $gifts->count();

            $statistics = collect($gifts)->groupBy('gift_id')->map(function ($item, $key) {
                $data = [
                    'date' => Carbon::today()->format('Y-m-d'),
                    'gift_id' => $key,
                    'count' => collect($item)->count(),
//                    'created_at' => Carbon::now(),
//                    'updated_at' => Carbon::now(),
                ];
                return $data;
            })->values();

//            $this->info($count);

            $gift = [
                'date' => Carbon::today()->format('Y-m-d'),
                'count' => $count
            ];
//        }


        $statistics = collect($statistics)->toArray();

        foreach ($statistics as $statistic) {
            GiftHistoryStatistic::query()->updateOrCreate([
                'date' => $statistic['date'],
                'gift_id' => $statistic['gift_id']
            ], [
                'count' => $statistic['count']
            ]);
        }

//        foreach ($gift as $item) {
        UserGiftsStatistics::updateOrCreate([
            'date' => $gift['date'],
        ], [
            'count' => $gift['count']
        ]);
//        }
    }
}
