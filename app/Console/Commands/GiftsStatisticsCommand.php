<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Usoft\Statistics\Models\GiftHistoryStatistic;
use Usoft\UsersGifts\Models\UserGiftsStatistics;
use Usoft\UsersGifts\Models\UsersGift;
use Carbon\Carbon;

class GiftsStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gifts:monthly';

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

        $gift = [];
        $statistics = [];
        for ($i = 0; $i <= 30; $i++) {
            $gifts = UsersGift::query()
                ->whereBetween('created_at', [Carbon::today()->subDays($i)->startOfDay()->subHours(5), Carbon::today()->subDays($i)->endOfDay()->subHours(5)])
                ->get();

            $count = $gifts->count();

            $statistics[] = collect($gifts)->groupBy('gift_id')->map(function ($item, $key) use ($i) {
                $data = [
                    'date' => Carbon::today()->subDays($i)->format('Y-m-d'),
                    'gift_id' => $key,
                    'count' => collect($item)->count(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                return $data;
            })->values();

            $this->info($count);

            $gift[] = [
                'date' => Carbon::today()->subDays($i)->format('Y-m-d'),
                'count' => $count
            ];
        }

        GiftHistoryStatistic::query()->insert(collect($statistics)->flatten(1)->toArray());

        foreach ($gift as $item) {
            UserGiftsStatistics::updateOrCreate([
                'date' => $item['date'],
            ], [
                'count' => $item['count']
            ]);
        }
    }
}
