<?php

namespace App\Http\Controllers\Gifts;

use App\Domain\Gifts\Resources\GiftsFilterFieldsResources;
use App\Domain\UsersGifts\Resources\UsersGiftsStatisticsWithTotalResource;
use App\Http\Requests\Paginate\PaginationRequest;
use App\Services\PaginateService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Type;
use Usoft\Gifts\Models\Gift;
use Usoft\Gifts\Resources\GiftResources;
use Usoft\UsersGifts\Models\UserGiftsStatistics;
use Usoft\UsersGifts\Resources\UsersGiftsPaginateResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Usoft\UsersGifts\Models\UsersGift;
use Usoft\UsersGifts\Resources\UsersGiftsResources;
use Usoft\UsersGifts\Resources\UsersGiftsStatisticsResources;
use Usoft\UserSubscribers\Models\UserSubscriber;
use Usoft\UserSubscribers\Resources\UserSubscribersPaginateResources;

class UsersGiftController extends Controller
{
    protected $request;
    protected $perPage;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->perPage = (new PaginateService())->perPage();
    }

    public function index(UserSubscriber $userSubscriber)
    {
        $gift = UsersGift::query()->orderBy('created_at', 'DESC')->with('gift', 'subscriber')
            ->where('user_id', (integer)$userSubscriber->id)
            ->when($this->request->has('gift_id'), function ($query) {
                $query->whereHas('gift', function ($query) {
                    $query->where('id', $this->request->input('gift_id'));
                });
            })->when($this->request->has('premium'), function ($query) {
                $query->where('premium', (boolean)$this->request->input('premium'));
            })->when($this->request->has('step'), function ($query) {
                $query->where('step', (integer)$this->request->input('step'));
            })->paginate($this->perPage);

        return new UsersGiftsPaginateResource($gift);
    }


//    public function store(Request $request)
//    {
//
//        for ($i = 0; $i <= 30; $i++){
//            return UsersGift::create([
//                'gift_id' => 2,
//                'user_id' => 14,
//                'game' => true,
//                'premium' => false,
//                'step'=> 2,
//                'price' => 120,
//                'created_at' => Carbon::today()->subDays($i)
//            ]);
//        }
//
//    }


    public function statistics()
    {
        return Cache::remember('statistics-gifts-monthly', 1200, function () {

            $statistics = UserGiftsStatistics::query()->whereBetween('date', [Carbon::today()->subDays(30), Carbon::today()])
                ->orderBy('date', 'ASC')->get();

            return new UsersGiftsStatisticsWithTotalResource($statistics);
        });

    }
}
