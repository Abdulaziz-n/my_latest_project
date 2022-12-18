<?php

namespace App\Http\Controllers;

use App\Services\PaginateService;
use Illuminate\Support\Facades\Date;
use Usoft\ActivityLog\Resources\ActivityLogWithPaginateResource;
use Illuminate\Http\Request;
use Illuminate\Redis\Limiters\ConcurrencyLimiterBuilder;
use Jenssegers\Mongodb\Query\Builder;
use Usoft\ActivityLog\Models\Log;
use Usoft\ActivityLog\Resources\ActivityLogResources;
use Carbon\Carbon;
use DateTime;
use Usoft\RabbitRpc\Services\ProducerRpc;
use function Aws\map;

class LogController extends Controller
{
    protected $request;
    protected $perPage;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->perPage = (new PaginateService())->perPage();
    }

    public function index()
    {
        $log = Log::with('user')->latest()->when($this->request->has('action'), function ($query) {
            $query->where('action', "{$this->request->action}");
        })->when($this->request->has('phone'), function ($query) {
            $phone = $this->request->phone;
            $query->where(function ($query) use ($phone) {
                $query->where('phone', (string)$phone)
                    ->orWhere('phone', (int)$phone);
            });
        })->paginate($this->perPage);

        return new ActivityLogWithPaginateResource($log);
    }
//
//    public function store(Request $request)
//    {
//        $log = Log::query()->create([
//            'user_id' => $request->user_id,
//            'phone' => $request->phone,
//            'action' => $request->action,
//            'data' => $request->data
//        ]);
//
//        return response()->json($log);
//    }

    public function actions()
    {
        $log = Log::groupBy('action')->pluck('action');

        return $log;
    }

    public function rpcDeposit()
    {
        $deposit = (new ProducerRpc())->setQueueName('deposit_paynet')->call(json_encode([
            'app_id' => 'all'
        ]));

        return json_decode($deposit);
    }

}
