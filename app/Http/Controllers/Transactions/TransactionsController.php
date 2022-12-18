<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Services\PaginateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Usoft\Levels\Models\Level;
use Usoft\Levels\Resources\LevelsResources;
use Usoft\Transactions\Models\Transaction;
use Usoft\Transactions\Resources\TransactionPaginateResources;
use Usoft\Transactions\Resources\TransactionResources;
use Usoft\UsersGifts\Models\UsersGift;
use Usoft\UserSubscribers\Models\UserSubscriber;

class TransactionsController extends Controller
{
    protected $perPage;

    public function __construct()
    {
        $this->perPage = (new PaginateService())->perPage();
    }

    public function index(UserSubscriber $userSubscriber, Request $request)
    {
        $transaction = Transaction::with('level', 'user')
            ->when($request->get('level_id') ?? false, function ($query, $level) {
                $query->whereHas('level', function ($query) use ($level) {
                    $query->where('id', $level);
                });
            })->where('user_id', $userSubscriber->id)
            ->paginate($this->perPage);

        return new TransactionPaginateResources($transaction);
    }

    public function filterFields()
    {
        $levels = Level::all();

        return LevelsResources::collection($levels)->all();
    }

    public function store()
    {
        return Transaction::query()->create([
            'user_id' => 14,
            'scores' => 150,
            'level_id' => 2,
            'step' => 1,
        ]);
    }

    public function total(UserSubscriber $userSubscriber)
    {
        $level_1 = Level::where('id', 1)->value('score');
        $level_2 = Level::where('id', 2)->value('score');
        $level_3 = Level::where('id', 3)->value('score');


        $transaction_level_1 = Transaction::where('user_id', $userSubscriber->id)
            ->where('level_id', 1)->sum('scores');
        $transaction_level_2 = Transaction::where('user_id', $userSubscriber->id)
            ->where('level_id', 2)->sum('scores');
        $transaction_level_3 = Transaction::where('user_id', $userSubscriber->id)
            ->where('level_id', 3)->sum('scores');


        $percent_level_1 = ($transaction_level_1 / $level_1) * 100;
        $percent_level_2 = ($transaction_level_2 / $level_2) * 100;
        $percent_level_3 = ($transaction_level_3 / $level_3) * 100;

        return [
            'percents' => [
                'level_1' => $percent_level_1,
                'level_2' => $percent_level_2,
                'level_3' => $percent_level_3
            ],
            'total_scores' => [
                'level_1' => $transaction_level_1,
                'level_2' => $transaction_level_2,
                'level_3' => $transaction_level_3
            ]
        ];

    }
}
