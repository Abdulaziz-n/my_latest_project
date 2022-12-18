<?php

namespace App\Http\Controllers;

use App\Domain\Gifts\Resources\GiftsFilterFieldsResources;
use App\Domain\Resources\FilterFieldsUserSubscriber;
use App\Domain\Uzmobile\Services\InformationController;
use App\Policies\ActivePackPolicy;
use App\Services\InformationService;
use App\Services\PaginateService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Type;
use Usoft\ActivityLog\Models\Log;
use Usoft\ActivityLog\Resources\ActivityLogResources;
use Usoft\ActivityLog\Resources\ActivityLogWithPaginateResource;
use Usoft\Exceptions\UzmobileErrorException;
use Usoft\Gifts\Models\Gift;
use Usoft\RabbitMq\Services\SendService;
use Usoft\Resources\ErrorResources;
use Usoft\TGSubscriber\Models\TelegramSubscriber;
use Usoft\UsersGifts\Models\UsersGift;
use Usoft\UserSubscribers\Models\UserSubscriber;
use Usoft\UserSubscribers\Models\UserSubscriberStatistic;
use Usoft\UserSubscribers\Resources\UserSubscribersPaginateResources;
use Usoft\UserSubscribers\Resources\UserSubscribersResource;
use Usoft\UserSubscribers\Resources\UserSubscriberStatisticsResource;
use Usoft\Uzmobile\Jobs\ActivateServiceJob;
use Usoft\Uzmobile\Jobs\DeactivateServiceJob;
use Usoft\Uzmobile\Resources\PersonalSubscriberResources;
use Usoft\Uzmobile\Resources\UserSubscriberGiftsResources;
use Usoft\Uzmobile\Services\PersonalSubscriberService;
use Usoft\Uzmobile\Services\SetByUserService;

class UserSubscriberController extends Controller
{
    protected $request;
    protected $perPage;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->perPage = (new PaginateService())->perPage();
    }

    public function store(Request $request)
    {
        return UserSubscriber::query()->create([
            'phone' => 999999999,
            'verify_code' => 232313,
            'verified' => true,
            'stop' => false,
            'business' => false,
            'first_prize' => true,
            'prize' => false,
            'language' => 'uzb',
            'company' => 'uzmobile',
            'subscriber_id' => 1313243,
            'personal_accountCustomer_id' => 33134141,
            'rate_plan_id' => 424242
        ]);
    }

//                'id' => 'integer',
//                'phone' => 'integer',
//                'verify_code' => 'integer',
//                'verified' => 'boolean',
//                'stop' => 'boolean',
//                'business' => 'boolean',
//                'first_prize' => 'boolean',
//                'prize' => 'boolean',
//                'language' => 'string',
//                'company' => 'string',
//                'subscriber_id' => 'integer',
//                'personal_accountCustomer_id' => 'integer',
//                'rate_plan_id' => 'integer',

    public function index()
    {
        $user = UserSubscriber::when($this->request->has('search'), function ($query) {
            $query->where('phone', 'like', "%{$this->request->input('search')}%");
        })->when($this->request->has('user_id'), function ($query) {
            $query->where('id', $this->request->get('user_id'));
        })->latest('id', 'desc')->paginate($this->perPage);

        return new UserSubscribersPaginateResources($user);
    }

    public function view(UserSubscriber $userSubscriber)
    {
        return new UserSubscribersResource($userSubscriber);
    }

    public function log(UserSubscriber $userSubscriber)
    {
        $log = Log::where('user_id', $userSubscriber->id)
            ->when($this->request->has('action'), function ($query) {
                $query->where('action', "{$this->request->get('action')}");
            })->latest()->paginate($this->perPage);

        return new ActivityLogWithPaginateResource($log);

    }

    public function activate(UserSubscriber $userSubscriber)
    {
        if ($userSubscriber->stop === true) {
            $activate = ActivateServiceJob::dispatchNow($userSubscriber);
        } else
            $activate = DeactivateServiceJob::dispatchNow($userSubscriber);
        return $activate;
    }

    public function personal(UserSubscriber $userSubscriber)
    {
        $information = (new PersonalSubscriberService())->subscriber($userSubscriber);

        $status = (new PersonalSubscriberService())->checkService($userSubscriber);

        $customer = (new PersonalSubscriberService())->customer($userSubscriber);

        $balance = (new PersonalSubscriberService())->rtBalance($userSubscriber);

        $data = collect($information)
            ->merge($customer)
            ->merge($status)
            ->merge($balance);

        return $data;
    }

    public function filterFields()
    {
        $gifts = Gift::query()->get();

        return new FilterFieldsUserSubscriber($gifts);
    }

    public function packet(UserSubscriber $userSubscriber, Request $request)
    {
        $this->authorize(ActivePackPolicy::ACTIVATE, UserSubscriber::class);

        $comment = $request->input('comment');
        $gift_id = $request->input('gift_id');
        $step = $request->input('step');
        $type = $request->input('type');

        $gift = Gift::query()->find($gift_id);

        try {
            $pack = (new InformationService())->activePack($userSubscriber->subscriber_id, $gift->package_id, $comment);
        } catch (UzmobileErrorException|\Exception $e) {
            return \response()->json([
                'message' => 'Uzmobile error, we can not connect package'
            ], 403);
//            return (new ErrorResources($e))->response()->setStatusCode(403);
        }

        // log

        (new SendService())->queue_declare('logger', [
            'user_id' => $userSubscriber->id,
            'phone' => $userSubscriber->phone,
            'action' => 'set_manual_gift',
            'data' => [
                'prize' => [
                    'id' => $gift->id,
                    'name' => $gift->name
                ],
                'uzmobile' => $pack,
            ]
        ]);

        $gift = UsersGift::query()->create([
            'premium' => $type == 'premium',
            'game' => false,
            'gift_id' => $gift_id,
            'user_id' => $userSubscriber->id,
            'step' => $step,
            'price' => $gift->price
        ]);

        return response()->json($gift);
    }

    public function setByUser(UserSubscriber $userSubscriber, Request $request)
    {

        $staff = $request->input('user_id');
        $step = $request->input('step');
        $type = $request->input('type');
        $type_package = $request->input('type_package') ?? null;
//        $comment = $request->input('comment');

//        $randGift = Gift::query()->where('premium', false)->inRandomOrder()->get();
//
//        if ($type == 'premium')
//            $randGift = Gift::query()->where('premium', true)->inRandomOrder()->get();
//
//        $gift = Gift::query()->find($gift_id) ?? $randGift;

//        try {
//            $pack = (new InformationService())->activePack($userSubscriber->subscriber_id, $gift->package_id, $comment);
//        } catch (UzmobileErrorException|\Exception $e) {
//            return \response()->json([
//                'message' => 'Uzmobile error, we can not connect package'
//            ], 403);
//            return (new ErrorResources($e))->response()->setStatusCode(403);
//        }

        // log

        $hash = md5("{$userSubscriber->phone}{$type}" . Str::random(22));

        (new SendService())->queue_declare('logger', [
            'user_id' => $userSubscriber->id,
            'phone' => $userSubscriber->phone,
            'action' => 'set_by_user',
            'data' => [
                'user' => $staff,
                'hash' => $hash,
                'step' => $step,
                'type' => $type,
                'package_type' => $type_package
            ]
        ]);

        try {
            $set = (new SetByUserService())->sendQueue($step, $userSubscriber, $type, $hash, $type_package);
            return $set;
        } catch (\Exception $exception) {
            return \response()->json([
               'message' => "Error,set by user, Code: {$exception->getMessage()}"
            ]);
        }

//        $gift = UsersGift::query()->create([
//            'premium' => $type == 'premium',
//            'game' => false,
//            'gift_id' => $gift_id ?? $randGift->value('id'),
//            'user_id' => $userSubscriber->id,
//            'step' => $step,
//            'price' => $gift->price
//        ]);

//        return response()->json($gift);
    }

    public function total()
    {
//        ini_set('memory_limit', '1024M');

        $active = UserSubscriber::where('stop', false)->where('verified', true)
            ->count();
        $inactive = UserSubscriber::where('stop', true)->where('verified', true)
            ->count();

        return [
            'active' => $active,
            'inactive' => $inactive,
            'total' => $active + $inactive,
        ];
    }

    public function verified()
    {
        $verified = UserSubscriber::where('verified', true)->count();
        $unverified = UserSubscriber::where('verified', false)->count();

        return [
            'verified' => $verified,
            'unverified' => $unverified
        ];
    }

    public function monthly()
    {
        return Cache::remember('statistics-subscribers-monthly', 1200, function () {

            $users = UserSubscriberStatistic::query()->orderByDesc('date')->whereBetween('date', [Carbon::today()->subDays(30), Carbon::today()])->get();

            return UserSubscriberStatisticsResource::collection($users)->all();
        });

    }

    public function daily()
    {
        $users = UserSubscriberStatistic::query()
            ->whereBetween('date', [Carbon::today(), Carbon::today()->endOfDay()])->get();

        return UserSubscriberStatisticsResource::collection($users)->all();
    }

}
