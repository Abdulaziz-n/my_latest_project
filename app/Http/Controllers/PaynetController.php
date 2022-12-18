<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Informations\PrizeController;
use Illuminate\Http\Request;
use Usoft\RabbitRpc\Services\ProducerRpc;

class PaynetController extends Controller
{
    public function rpcDeposit()
    {
        $deposit = (new ProducerRpc())->setQueueName('deposit_paynet')->call(json_encode([
            'app_id' => 'all'
        ]));

        return json_decode($deposit);
    }

    public function totalCount(Request $request)
    {
        $monthly = (new ProducerRpc())->setQueueName('paynet-statistics')->call(json_encode([
            'type' => 'totalCount',
            'app_id'=> $request->input('app_id')
        ]));

        return json_decode($monthly);
    }
    public function totalAmount(Request $request)
    {
        $monthly = (new ProducerRpc())->setQueueName('paynet-statistics')->call(json_encode([
            'type' => 'totalAmount',
            'app_id'=> $request->input('app_id')
        ]));

        return json_decode($monthly);
    }
    public function failedTotalCount(Request $request)
    {
        $monthly = (new ProducerRpc())->setQueueName('paynet-statistics')->call(json_encode([
            'type' => 'failedTotalCount',
            'app_id'=> $request->input('app_id')
        ]));

        return json_decode($monthly);
    }
    public function failedTotalAmount(Request $request)
    {
        $monthly = (new ProducerRpc())->setQueueName('paynet-statistics')->call(json_encode([
            'type' => 'failedTotalAmount',
            'app_id'=> $request->input('app_id')
        ]));

        return json_decode($monthly);
    }

    public function transactions(Request $request)
    {
        $transactions = (new ProducerRpc())->setQueueName('transactions')->call(json_encode([
          'app_id' => $request->input('app_id'),
          'status' => $request->input('status'),
          'service_id' => $request->input('service_id'),
          'perPage' => $request->input('perPage'),
          'page' => $request->input('page')
        ]));

        return json_decode($transactions);
    }

    public function appList()
    {
        $apps = (new ProducerRpc())->setQueueName('apps-get')->call(json_encode([
            'type' => 'apps'
        ]));

        return json_decode($apps);
    }
}
