<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Usoft\Charges\Models\ChargeStatistic;
use Usoft\Statistics\Models\GiftHistoryStatistic;
use Carbon\Carbon;

class InvoiceExport implements FromView
{
    public function view(): View
    {
        if (request()->get('date_start')) {
            $date = request()->get('date_start');
        } else {
            $date = Carbon::today();
        }

        if (request()->get('date_end')) {
            $date_end = request()->get('date_end');
        } else {
            $date_end = Carbon::today();
        }

        $date = Carbon::parse($date);
        $date_end = Carbon::parse($date_end)->endOfDay();

//        $daily = Charge::query()->whereBetween('date', [$date->format('Y-m-d'), $date_end->format('Y-m-d')])->where('status', true)->get();
//        $premium = ChargePremium::query()->whereBetween('date', [$date->format('Y-m-d'), $date_end->format('Y-m-d')])->where('status', true)->get();
//        $merge = collect($daily)->merge($premium);//->merge($level);//->sum('price');

//        $groups =  $merge->groupBy('tariff');

        $charges = ChargeStatistic::query()
            ->orderBy('date', 'DESC')
            ->where('type', 'charged')
            ->whereBetween('date', [$date, $date_end])
            ->get();

        $merge = collect($charges);

        $groups =  $merge->groupBy('tariff');

        $tariffs = [
            [
                'name' => 2601,
                'revenue' => 0,
                'count' => 0,
                'price' => 500
            ],

            [
                'name' => 2602,
                'revenue' => 0,
                'count' => 0,
                'price' => 700

            ],

            [
                'name' => 2603,
                'revenue' => 0,
                'count' => 0,
                'price' => 1000
            ],

            [
                'name' => 2604,
                'revenue' => 0,
                'count' => 0,
                'price' => 2000
            ],

            [
                'name' => 2605,
                'revenue' => 0,
                'count' => 0,
                'price' => 3000
            ],

            [
                'name' => 2606,
                'revenue' => 0,
                'count' => 0,
                'price' => 4000
            ],
        ];

        $types = [];

        $expense = GiftHistoryStatistic::query()->whereBetween('date', [$date, $date_end])->get();

        $expense = $expense->map(function ($ex) {
            if (!empty($ex->gift->price)) {
                $ex->price = $ex->gift->price * $ex->count;
            } else {
                return null;
            }
            return $ex;
        })->filter()->values();

        $total_expense = $expense->sum('count');
        $rasxod = $expense->sum('price');

        $doxod_sum = 0;
        $charges_count = 0;
        $rasxod_sum = 0;

        foreach ($tariffs as $tariff) {
            $count = !empty($groups[$tariff['name']]) ? collect($groups[$tariff['name']])->sum('count') : 0;
            $revenue = !empty($groups[$tariff['name']]) ? (collect($groups[$tariff['name']])->sum('count') * $tariff['price']) : 0;

            $types[] = [
                'name' => $tariff['name'],
                'revenue' => $revenue,
                'count' => $count,
                'price' => $tariff['price']
            ];

            $doxod_sum += $revenue;
            $charges_count += $count;
        }

        $tariffs = [
            [
                'name' => 'total',
                'revenue' => 0,
                'count' => 0,
                'price' => 0
            ],

            [
                'name' => 'expense',
                'revenue' => 0,
                'count' => 0,
                'price' => 0
            ],

            [
                'name' => 'revenue',
                'revenue' => 0,
                'count' => 0,
                'price' => 0
            ],
        ];

        foreach ($tariffs as $tariff) {
            if ($tariff['name'] == 'total') {
                $types[] = [
                    'name' => $tariff['name'],
                    'revenue' => $doxod_sum,
                    'count' => $charges_count,
                    'price' => $tariff['price'] / 1.15
                ];

//                $doxod_sum = collect($groups)->flatten(1)->sum('price') / 1.15;
            } else if ($tariff['name'] == 'expense') {
                $types[] = [
                    'name' => $tariff['name'],
                    'revenue' => $rasxod,
                    'count' => $total_expense,
                    'price' => 0
                ];

                $rasxod_sum = $rasxod;
            } else if ($tariff['name'] == 'revenue') {
                $types[] = [
                    'name' => $tariff['name'],
                    'revenue' => $doxod_sum - $rasxod_sum / 1.5 * 0.5,
                    'count' => 0,
                    'price' => 0
                ];
            }
        }



        $gifts = collect($expense)->map(function ($history) {
//            $gift = Gift::query()->find($key);
            switch ($history->gift->type) {
                case 'internet':
                    $per_price = 1.47;
                    break;
                case 'voice':
                    $per_price = 1.40;
                    break;
                default:
                    $per_price = 1.00;
                    break;
            }
            $data = [
                'gift' => $history->gift,
                'count' => $history->count,
                'per_price' => $per_price,
                'profit' => $history->gift->price * $history->count
            ];

            return $data;
        })->values();

        $gifts = $gifts->groupBy('gift')->map(function ($value, $key) {
            return [
                'gift' => $value->first()['gift'],
                'count' => $value->sum('count'),
                'per_price' => $value->first()['per_price'],
                'profit' => $value->sum('profit')
            ];
        })->values();


        $data = collect([
            'invoices' => $types
        ])->merge([
            'gifts' => $gifts
        ]);

        return view('excel.export_statistics', compact('data'));
    }
}
