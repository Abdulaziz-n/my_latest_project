<?php

namespace App\Http\Controllers\Charge;

use App\Exports\InvoiceExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Usoft\Charges\Models\Charge;
use Usoft\Charges\Models\ChargeMonthlyStatistic;
use Usoft\Charges\Models\ChargePremium;
use Usoft\Charges\Models\ChargeStatistic;
use Usoft\Gifts\Models\Gift;
use Usoft\Statistics\Models\GiftHistoryStatistic;
use Usoft\UsersGifts\Models\UserGiftsStatistics;
use Usoft\UsersGifts\Models\UsersGift;
use Usoft\UsersGifts\Resources\UsersGiftsStatisticsResources;
use Usoft\UserSubscribers\Models\UserSubscriber;
use Usoft\UserSubscribers\Models\UserSubscriberStatistic;
use function PHPUnit\Framework\returnArgument;

class ChargeController extends Controller
{
    public function store()
    {
        $tarrifs = [
            2601,
            2602,
            2603,
            2604,
            2605,
            2606
        ];
        for ($i = 0; $i <= 30; $i++) {
            foreach ($tarrifs as $tarrif) {
                if ($tarrif >= 2604) {
                    ChargePremium::query()->create([
                        'attempt' => 2,
                        'charged_at' => Carbon::now(),
                        'date' => Carbon::today()->subDays($i)->format('Y-m-d'),
                        'last_attempt' => Carbon::yesterday(),
                        'status' => 0,
                        'tariff' => $tarrif,
                        'user_id' => 14,
                        'stop' => true,
                        'subscribe' => true,
                        'phone' => 9912345678,
                        'price' => 120.000,
                        'uuid' => '16385f78-74c7-4497-9554-62d7d649e571',
                        'created_at' => Carbon::today()->subDays($i)
                    ]);
                } else
                    Charge::query()->create([
                        'attempt' => 2,
                        'charged_at' => Carbon::now(),
                        'date' => Carbon::today()->subDays($i)->format('Y-m-d'),
                        'last_attempt' => Carbon::yesterday(),
                        'status' => 0,
                        'tariff' => $tarrif,
                        'user_id' => 14,
                        'stop' => true,
                        'subscribe' => true,
                        'phone' => 9912345678,
                        'price' => 120.000,
                        'uuid' => '16385f78-74c7-4497-9554-62d7d649e571',
                        'created_at' => Carbon::today()->subDays($i)
                    ]);
            }


        }
        return Charge::all();
    }


    public function scheduleInsert($tariff)
    {

    }


//    public function

    public function invoice()
    {
        return Cache::remember('statistics-invoice', 600, function () {
            $data = ChargeMonthlyStatistic::query()->orderBy('date', 'ASC')->whereBetween('date', [Carbon::today()->subDays(30)->endOfDay(), Carbon::today()->startOfDay()])
                ->get();

            $charged = $data->where('type', 'charged')->pluck('count');
            $uncharged = $data->where('type', 'uncharged')->pluck('count');
            $date = $data->unique('date')->pluck('date');

            return [
                'charged' => $charged,
                'uncharged' => $uncharged,
                'date' => $date,
                'overall' =>  collect($charged)->sum() //+ $uncharged
            ];
        });
    }

    public function monthlyStatistics($tariff)
    {
        return Cache::remember("statistics-charge-{$tariff}-monthly", 600, function () use ($tariff) {

            $charge = ChargeStatistic::query()->orderBy('date', 'DESC')->where('tariff', $tariff)->limit(60)->get();

            $dates = $charge->sortBy('date')->pluck('date')->unique()->values();

            $charged = $charge->reverse()->values()->filter(function ($filter) {
                if ($filter->type === 'charged')
                    return $filter;
            })->pluck('count');

            $uncharged = $charge->reverse()->values()->filter(function ($filter) {
                if ($filter->type === 'uncharged')
                    return $filter;
            })->pluck('count');

            switch ($tariff) {
                case 2602:
                    $price = 700;
                    break;
                case 2603:
                    $price = 1000;
                    break;
                case 2604:
                    $price = 2000;
                    break;
                case 2605:
                    $price = 3000;
                     break;
                case 2606:
                    $price = 4000;
                    break;
                default:
                    $price = 500;
                    break;
            }

            return [
                'charged' => $charged,
                'date' => $dates,
                'uncharged' => $uncharged,
                'price' => $price
            ];
        });
    }

    public function dailyStatistics($tariff)
    {
       return Cache::remember("statistics-charge-{$tariff}-daily", 600, function () use ($tariff) {

            $charge = ChargeStatistic::query()->orderBy('date', 'DESC')->whereDate('date', Carbon::today()->format('Y-m-d'))
                ->where('tariff', $tariff)->get();

            $charged = $charge->where('type', 'charged')->map(function ($value) {
                return $value->count;
            })->values();

            $uncharged = $charge->where('type', 'uncharged')->map(function ($value) {
                return $value->count;
            })->values();

            return [
                'charged' => $charged,
                'uncharged' => $uncharged
            ];
        });

    }


//    public function

    public function profit_total()
    {
        return Cache::remember("statistics-charge-total-home-daily", 600, function () {
            $dates = [];
            $charges = [];

            $count = 0;

            for ($x=0; $x++<30;) {
                if ($x == 1) {
                    $date = Carbon::today()->format('Y-m-d');
                } else {
                    $day = $x - 1;
                    $date = Carbon::today()->subDays($day)->format('Y-m-d');
                }

                $charge = ChargeStatistic::query()
                    ->orderBy('date', 'DESC')
                    ->where('type', 'charged')
                    ->whereDate('date', $date)
                    ->get();

                $daily = 0;

                if (!empty($charge)) {
                    foreach ($charge as $item) {
                        $count += $item->count;
                        switch ($item->tariff) {
                            case 2602:
                                $daily += 700 * $item->count;
//                        $doxod += 700 * $item->count;
                                break;
                            case 2603:
                                $daily += 1000 * $item->count;
//                        $doxod += 1000 * $item->count;
                                break;
                            case 2604:
                                $daily += 2000 * $item->count;
//                        $doxod += 3000 * $item->count;
                                break;
                            case 2605:
                                $daily += 3000 * $item->count;
//                        $doxod += 4000 * $item->count;
                                break;
                            case 2606:
                                $daily += 4000 * $item->count;
//                        $doxod +=  5000 * $item->coun;
                                break;
                            default:
                                $daily += 500 * $item->count;
//                        $doxod +=  500 * $item->count;
                                break;
                        }
                    }
                } else {
                    $charges[] = 0;
                }


                $charges[] = round($daily);

                $dates[] = $date;
            }

            $doxod = 0;

            $charges_total = ChargeStatistic::query()
                ->orderBy('date', 'DESC')
                ->where('type', 'charged')
                ->whereBetween('date', [Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth()])
                ->get();

            $merge = collect($charges_total);

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
            foreach ($tariffs as $tariff) {
                $count = !empty($groups[$tariff['name']]) ? collect($groups[$tariff['name']])->sum('count') : 0;
                $revenue = !empty($groups[$tariff['name']]) ? (collect($groups[$tariff['name']])->sum('count') * $tariff['price']) : 0;

                $types[] = [
                    'name' => $tariff['name'],
                    'revenue' => $revenue,
                    'count' => $count,
                    'price' => $tariff['price']
                ];

                $doxod += $revenue;
            }

            return [
                'dates' => collect($dates)->reverse()->values(),
                'charges' => collect($charges)->reverse()->values(),
                'overall' => round($doxod),
            ];
        });
    }

    public function profit_expense()
    {
        return Cache::remember("statistics-charge-expense-home-daily", 600, function () {

            $dates = [];
            $charges = [];

            $count = 0;

            $rasxod = 0;
            $daily_rasxod = [];

            for ($x=0; $x++<30;) {
                if ($x == 1) {
                    $date = Carbon::today()->format('Y-m-d');
                } else {
                    $day = $x - 1;
                    $date = Carbon::today()->subDays($day)->format('Y-m-d');
                }

                $expense = GiftHistoryStatistic::query()->whereDate('date', $date)->get();

                if (count($expense) > 0) {
                    $expense = $expense->map(function ($ex) {
                        if (!empty($ex->gift->price)) {
                            $ex->price = $ex->gift->price * $ex->count;
                        } else {
                            return  null;
                        }

                        return $ex;
                    })->filter()->values();

                    $daily = $expense->sum('price');
                } else {
                    $daily = 0;
                }

                $dates[] = $date;
                $daily_rasxod[] = $daily;
                $rasxod += $daily;
            }


            $overall = GiftHistoryStatistic::query()->whereBetween('date', [
                Carbon::today()->startOfMonth(),
                Carbon::today()->endOfMonth()
            ])->get();

            $overall = $overall->map(function ($ex) {
                if (!empty($ex->gift->price)) {
                    $ex->price = $ex->gift->price * $ex->count;
                } else {
                    return null;
                }

                return $ex;
            })->filter()->values();

            return [
                'dates' => collect($dates)->reverse()->values(),
                'charges' => collect($daily_rasxod)->reverse()->values(),
                'overall' => round($overall->sum('price')),
            ];
        });
    }

    public function profit_revenue()
    {
        Log::error("TEST ULA");
        return Cache::remember("statistics-charge-revenue-home-daily", 600, function () {
            $dates = [];
            $charges = [];

            $count = 0;

            $rasxod = 0;
            $daily_rasxod = [];

            for ($x=0; $x++<30;) {
                if ($x == 1) {
                    $date = Carbon::today()->format('Y-m-d');
                } else {
                    $day = $x - 1;
                    $date = Carbon::today()->subDays($day)->format('Y-m-d');
                }

                $expense = GiftHistoryStatistic::query()->whereDate('date', $date)->get();

                if (count($expense) > 0) {
                    $expense = $expense->map(function ($ex) {
                        if (!empty($ex->gift->price)) {
                            $ex->price = $ex->gift->price * $ex->count;
                        } else {
                            return  null;
                        }

                        return $ex;
                    })->filter()->values();

                    $daily_expense = $expense->sum('price');
                } else {
                    $daily_expense = 0;
                }

                $charge = ChargeStatistic::query()
                    ->orderBy('date', 'DESC')
                    ->where('type', 'charged')
                    ->whereDate('date', $date)
                    ->get();

                $daily = 0;

                if (!empty($charge)) {
                    foreach ($charge as $item) {
                        $count += $item->count;
                        switch ($item->tariff) {
                            case 2602:
                                $daily += 700 * $item->count;
                                break;
                            case 2603:
                                $daily += 1000 * $item->count;
                                break;
                            case 2604:
                                $daily += 2000 * $item->count;
                                break;
                            case 2605:
                                $daily += 3000 * $item->count;
                                break;
                            case 2606:
                                $daily += 4000 * $item->count;
                                break;
                            default:
                                $daily += 500 * $item->count;
                                break;
                        }
                    }
                } else {
                    $charges[] = 0;
                }

                $dates[] = $date;
                $daily_rasxod[] = $daily  - $daily_expense;
            }

            $overall = GiftHistoryStatistic::query()->whereBetween('date', [
                Carbon::today()->startOfMonth(),
                Carbon::today()->endOfMonth()
            ])->get();

            $overall = $overall->map(function ($ex) {
                if (!empty($ex->gift->price)) {
                    $ex->price = $ex->gift->price * $ex->count;
                } else {
                    return null;
                }

                return $ex;
            })->filter()->values();

            $doxod = 0;

            $charges_total = ChargeStatistic::query()
                ->orderBy('date', 'DESC')
                ->where('type', 'charged')
                ->whereBetween('date', [Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth()])
                ->get();

            $merge = collect($charges_total);

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
            foreach ($tariffs as $tariff) {
                $count = !empty($groups[$tariff['name']]) ? collect($groups[$tariff['name']])->sum('count') : 0;
                $revenue = !empty($groups[$tariff['name']]) ? (collect($groups[$tariff['name']])->sum('count') * $tariff['price']) : 0;

                $types[] = [
                    'name' => $tariff['name'],
                    'revenue' => $revenue,
                    'count' => $count,
                    'price' => $tariff['price']
                ];

                $doxod += $revenue;
            }

    //        $expense_rasxod = $overall->sum('price');
            return [
                'dates' => collect($dates)->reverse()->values(),
                'charges' => collect($daily_rasxod)->reverse()->values(),
                'overall' => round($doxod - $overall->sum('price')),
            ];
        });
    }

    public function profit()
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
                    'revenue' => $doxod_sum - $rasxod_sum , // / 1.5 * 0.5,
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

        return $data;
    }

    public function profit_excel()
    {
        return  Excel::download(new InvoiceExport, 'invoices.xlsx');
    }

    public function profit2()
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

        $daily = Charge::query()->whereBetween('date', [$date->format('Y-m-d'), $date_end->format('Y-m-d')])->where('status', true)->get();
        $premium = ChargePremium::query()->whereBetween('date', [$date->format('Y-m-d'), $date_end->format('Y-m-d')])->where('status', true)->get();
        $merge = collect($daily)->merge($premium);//->merge($level);//->sum('price');

//        $groups =  $merge->groupBy('tariff');

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

        $expense = UsersGift::query()->whereBetween('created_at', [$date, $date_end])->get();
        $rasxod = $expense->sum('price');

        $doxod_sum = 0;
        $rasxod_sum = 0;

        $count_total = 0;

        foreach ($tariffs as $tariff) {
            $charges = ChargeStatistic::query()
                    ->orderBy('date', 'DESC')
                    ->where('tariff', 2601)
                    ->where('type', 'charged')
                    ->whereBetween('date', [$date, $date_end])
                    ->get();

                $count = !empty($charges) && count($charges) > 0 ? $charges->map(function ($charge) {
                    return $charge->count;
                })->sum() : 0;

//                switch ($tariff['name']) {
//                    case 2601:
//                        $price = 500;
//                        $revenue = 500 * $count;
//                        break;
//                    case 2602:
//                        $price = 700;
//                        $revenue = 700 * $count;
//                        break;
//                    case 2603:
//                        $price = 1000;
//                        $revenue = 1000 * $count;
//                        break;
//                    case 2604:
//                        $price = 2000;
//                        $revenue = 2000 * $count;
//                        break;
//                    case 2605:
//                        $price = 3000;
//                        $revenue = 3000 * $count;
//                        break;
//                    case 2606:
//                        $price = 4000;
//                        $revenue = 4000 * $count;
//                        break;
//                }

                $doxod_sum += $count > 0 ? $tariff['price'] * $count : 0;

                $count_total += $count;
                $types[] = [
                    'name' => $tariff['name'],
                    'revenue' => $count > 0 ? $tariff['price'] * $count / 1.15  : 0,
                    'count' => $count,
                    'price' => $tariff['price'] / 1.15
                ];
        }

        $totals = [
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

        foreach ($totals as $total) {
            if ($total['name'] == 'total') {
                $types[] = [
                    'name' => $total['name'],
                    'revenue' => $doxod_sum / 1.15,
                    'count' => $count_total,
                    'price' => 0
                ];

//                $doxod_sum = collect($groups)->flatten(1)->sum('price') / 1.15;
            } else if ($total['name'] == 'expense') {
                $types[] = [
                    'name' => $total['name'],
                    'revenue' => $rasxod,
                    'count' => count($expense),
                    'price' => 0
                ];

                $rasxod_sum = $rasxod;
            } else if ($total['name'] == 'revenue') {
                $types[] = [
                    'name' => $total['name'],
                    'revenue' => ($doxod_sum / 1.15) - $rasxod_sum,
                    'count' => 0,
                    'price' => 0
                ];
            }
        }

//        foreach ($tariffs as $tariff) {
//            if ($tariff['name'] == 'total') {
//                $types[] = [
//                    'name' => $tariff['name'],
//                    'revenue' => collect($groups)->flatten(1)->sum('price') / 1.15,
//                    'count' => count(collect($groups)->flatten(1)) ?? 0,
//                    'price' => $tariff['price'] / 1.15
//                ];
//
//                $doxod_sum = collect($groups)->flatten(1)->sum('price') / 1.15;
//            } else if ($tariff['name'] == 'expense') {
//                $types[] = [
//                    'name' => $tariff['name'],
//                    'revenue' => $rasxod,
//                    'count' => count($expense),
//                    'price' => 0
//                ];
//
//                $rasxod_sum = $rasxod;
//            } else if ($tariff['name'] == 'revenue') {
//                $types[] = [
//                    'name' => $tariff['name'],
//                    'revenue' => $doxod_sum - $rasxod_sum,
//                    'count' => 0,
//                    'price' => 0
//                ];
//            } else {
//                $charges = ChargeStatistic::query()
//                    ->orderBy('date', 'DESC')
//                    ->where('tariff', 2601)
//                    ->where('type', 'charged')
//                    ->whereBetween('date', [$date, $date_end])
//                    ->get();
//
//                $count = !empty($charges) && count($charges) > 0 ? $charges->map(function ($charge) {
//                    return $charge->count;
//                })->sum() : 0;
//
//                switch ($tariff['name']) {
//                    case 2601:
//                        $price = 500;
//                        $revenue = 500 * $count;
//                        break;
//                    case 2602:
//                        $price = 700;
//                        $revenue = 700 * $count;
//                        break;
//                    case 2603:
//                        $price = 1000;
//                        $revenue = 1000 * $count;
//                        break;
//                    case 2604:
//                        $price = 2000;
//                        $revenue = 2000 * $count;
//                        break;
//                    case 2605:
//                        $price = 3000;
//                        $revenue = 3000 * $count;
//                        break;
//                    case 2606:
//                        $price = 4000;
//                        $revenue = 4000 * $count;
//                        break;
//                }
//
//                $types[] = [
//                    'name' => $tariff['name'],
//                    'revenue' => $revenue > 0 ? $revenue / 1.15  : 0,
//                    'count' => $count,
//                    'price' => $price / 1.15
//                ];
//            }
//
//        }

//        $gifts = collect($expense)->groupBy('gift_id')->map(function ($item, $key) {
//            $gift = Gift::query()->find($key);
//            $data = [
//                'gift' => $gift,
//                'count' => collect($item)->count()
//            ];
//
//            return $data;
//        })->values();


        $data = collect($types);//->merge($types);//->merge($gifts);

        return $data;
    }

}
