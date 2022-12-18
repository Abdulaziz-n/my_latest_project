<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Usoft\Charges\Models\Charge;
use Usoft\Charges\Models\ChargeMonthlyStatistic;
use Usoft\Charges\Models\ChargePremium;
use Carbon\Carbon;

class ChargeMonthlyStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charge:all';

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

        $charges = [];

        for ($i = 0; $i <= 30; $i++) {
            $this->info('test');
            $countPremium = ChargePremium::query()->where('status', 1)->orWhere('status', true)
                ->whereBetween('date', [Carbon::today()->subDays($i)->format("Y-m-d"), Carbon::today()->subDays($i)->format("Y-m-d")])
                ->count();

            $this->info('count Premium status 1 ' . $countPremium);
            $countDaily = Charge::query()->where('status', 1)->orWhere('status', true)
                ->whereBetween('date', [Carbon::today()->subDays($i)->format("Y-m-d"), Carbon::today()->subDays($i)->format("Y-m-d")])
                ->count();
            $this->info('count daily status 1 ' . $countDaily);
            $charges[] = [
                'count' => $countPremium + $countDaily,
                'type' => 'charged',
                'date' => Carbon::today()->subDays($i)->format('Y-m-d')
            ];

            $countPremium = ChargePremium::query()->where('status', 0)
                ->whereBetween('date', [Carbon::today()->subDays($i)->format("Y-m-d"), Carbon::today()->subDays($i)->format("Y-m-d")])
                ->count();
            $this->info('count premium status 0 '. $countPremium);
            $countDaily = Charge::query()->where('status', 0)
                ->whereBetween('date', [Carbon::today()->subDays($i)->format("Y-m-d"), Carbon::today()->subDays($i)->format("Y-m-d")])
                ->count();
            $this->info('count daily status 0 '. $countDaily);
            $charges[] = [
                'count' => $countPremium + $countDaily,
                'type' => 'uncharged',
                'date' => Carbon::today()->subDays($i)->format('Y-m-d')
            ];

        }

        foreach ($charges as $charge) {
            $this->info($charge['count']);
            $this->info($charge['date']);
            $this->info($charge['type']);
            ChargeMonthlyStatistic::updateOrCreate([
                'date' => $charge['date'],
                'type' => $charge['type'],
            ], [
                'count' => $charge['count']
            ]);
        }
    }
}
