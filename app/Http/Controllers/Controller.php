<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Usoft\Transactions\Models\Transaction;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function del()
    {
        $transaction = Transaction::query()->where('_id', '637a288b31ad37670e080b78')
            ->where('user_id', 187539)->delete();

//        $transaction->delete();

        return response()->json($transaction);
    }

    public function test()
    {

    }
}
