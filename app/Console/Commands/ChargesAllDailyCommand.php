<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Usoft\Charges\Models\Charge;
use Usoft\Charges\Models\ChargePremium;
use Usoft\Charges\Models\ChargeStatistic;

class ChargesAllDailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charge:daily';

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
        $tarrifs = [
            2601,
            2602,
            2603,
            2604,
            2605,
            2606
        ];

        ini_set('memory_limit', '1024M');

        $date = Carbon::today()->format('Y-m-d');

//        return Charge::query()->where('status', 0)->whereBetween('created_at', [Carbon::today()->subDays(1)->addHours(5), Carbon::today()->subDays(1)->endOfDay()->addHours(5)])->get();

        $charges = [];
//        return Carbon::today()->subDays(1);
//        ChargeStatistic::query()->truncate();

//        $c = Charge::query()
////            ->where('status', false)
//            ->whereBetween('date', [Carbon::today()->format("Y-m-d"), Carbon::today()->endOfDay()->format("Y-m-d")])
//            ->where(function ($query) {
//                $query->where('tariff', 2601)->orWhere('tariff', (string) 2601);
//            })
//            ->get();
//
//        $c = count($c);

//        $this->info("TARIFFF UN COUNT: {$c}");

//        for ($i = 0; $i <= 30; $i++) {
            foreach ($tarrifs as $tarrif) {
                $this->info("START {$tarrif} DAY: ". Carbon::today()->format("Y-m-d"));
                if ($tarrif >= 2604) {
                    $count = ChargePremium::query()->where('status', true)
                        ->whereBetween('date', [Carbon::today()->format("Y-m-d"), Carbon::today()->endOfDay()->format("Y-m-d")])
                        ->where(function ($query) use ($tarrif) {
                            $query->where('tariff', $tarrif)->orWhere('tariff', (string) $tarrif);
                        })
                        ->get();
                } else
                    $count = Charge::query()->where('status', true)
                        ->whereBetween('date', [Carbon::today()->format("Y-m-d"), Carbon::today()->endOfDay()->format("Y-m-d")])
                        ->where(function ($query) use ($tarrif) {
                            $query->where('tariff', $tarrif)->orWhere('tariff', (string) $tarrif);
                        })
                        ->get();


                $count = count($count);

                $this->info("CHARGED TARIFF {$tarrif} COUNT: {$count}");

                $charges[] = [
                    'tariff' => $tarrif,
                    'count' => $count,
                    'type' => 'charged',
                    'date' => Carbon::today()->format('Y-m-d')
                ];

                $this->info("CHARGE ARRAY {$tarrif}");

                if ($tarrif >= 2604) {
                    $this->info("TARIFF PREMIUM UNCHARGED");
                    $count = ChargePremium::query()
                        ->where(function ($query) {
                            $query->where('status', 0)->orWhere('status', false);
                        })
                        ->whereBetween('date', [Carbon::today()->format("Y-m-d"), Carbon::today()->endOfDay()->format("Y-m-d")])
                        ->where(function ($query) use ($tarrif) {
                            $query->where('tariff', $tarrif)->orWhere('tariff', (string) $tarrif);
                        })
                        ->get();
                    $this->info("GET PREMIUM UNCHARGED");
                } else {
                    $this->info("TARIFF DAILY UNCHARGED");
                    $count = Charge::query()->where(function ($query) {
                        $query->where('status', 0)->orWhere('status', false);
                    })
                        ->whereBetween('date', [Carbon::today()->format("Y-m-d"), Carbon::today()->endOfDay()->format("Y-m-d")])
                        ->where(function ($query) use ($tarrif) {
                            $query->where('tariff', $tarrif)->orWhere('tariff', (string) $tarrif);
                        })
                        ->get();

                    $this->info("GET DAILY UNCHARGED");
                }

                $count = count($count);

                $this->info("UN_CHARGED TARIFF {$tarrif} COUNT: {$count}");

                $charges[] = [
                    'tariff' => $tarrif,
                    'count' => $count,
                    'type' => 'uncharged',
                    'date' => Carbon::today()->format('Y-m-d')
                ];
            }
//        }
//        return $charges;
        foreach ($charges as $charge) {
            ChargeStatistic::updateOrCreate([
                'tariff' => $charge['tariff'],
                'date' => $charge['date'],
                'type' => $charge['type'],
            ],
                [
                    'count' => $charge['count']
                ]);
        }

//        return ChargeStatistic::all();
//        return 0;
    }
}
