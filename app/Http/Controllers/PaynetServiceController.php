<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Usoft\RabbitRpc\Services\ProducerRpc;

class PaynetServiceController extends Controller
{
    public function index()
    {
        $service = (new ProducerRpc())->setQueueName('crud-service')->call(json_encode([
            'method' => 'get-items'
        ]));

        return json_decode($service);
    }

    public function store(Request $request)
    {
//        return $request;
        $service = (new ProducerRpc())->setQueueName('crud-service')->call(json_encode([
            'method' => 'store',
            'data' => $request->all()
        ]));

        return json_decode($service);
    }

    public function update($service, Request $request)
    {

        if ($service == 1 ||  $service == 2){

            return response()->json('Update qilish mumkun mas');
        }

        if ($request->isMethod('get')){
            $data = (new ProducerRpc())->setQueueName('crud-service')->call(json_encode([
                'method' => 'get-item',
                'service' => (integer)$service
            ]));
            return json_decode($data);
        }

        $data = (new ProducerRpc())->setQueueName('crud-service')->call(json_encode([
            'method' => 'update',
            'service' => (integer)$service,
            'data' => $request->all()
        ]));

        return json_decode($data);

    }

    public function destroy($service, Request $request)
    {
        $service = (new ProducerRpc())->setQueueName('crud-service')->call(json_encode([
            'method' => 'delete',
            'service' => $service,
            'data' => $request
        ]));

        return json_decode($service);
    }

    public function uzmobile()
    {
        $service = (new ProducerRpc())->setQueueName('uzmobile_paynet')->call(json_encode([
            'phone' => "990060414",
            'user_id' => 44538,
            'amount' => 15000,
        ]));

        return json_decode($service);
    }
}
