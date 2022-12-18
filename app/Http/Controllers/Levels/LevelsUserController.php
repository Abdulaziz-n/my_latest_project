<?php

namespace App\Http\Controllers\Levels;

//use Illuminate\Support\Facades\Log;
use Usoft\Levels\Resources\LevelsUserResources;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Usoft\Levels\Models\LevelsUser;
use Usoft\Levels\Resources\LevelsUsersPaginateResources;
use Usoft\UserSubscribers\Models\UserSubscriber;
use App\Services\PaginateService;
use Usoft\ActivityLog\Models\Log;

class LevelsUserController extends Controller
{
    protected $perPage;

    public function __construct()
    {
        $this->perPage = (new PaginateService())->perPage();
    }

    public function index(Request $request)
    {
        $levels = LevelsUser::query()->orderByDesc('created_at')->with('user', 'levelGift')
            ->when($request->get('phone') ?? false, function ($query, $phone) {
                $query->whereHas('user', function ($query) use ($phone) {
                    $query->where('phone', $phone);
                });
            })->when($request->get('user_id') ?? false, function ($query, $user) {
                    $query->where('user_id', $user);
            })->when($request->get('types') ?? false, function ($query, $types) {
                $query->whereHas('levelGift', function ($query) use ($types) {
                    $query->whereIn('type', $types);
                });
            })->when($request->get('level_id') ?? false, function ($query, $level) {
                $query->where('level_id', (integer)$level);
            })->paginate($this->perPage);

        return new LevelsUsersPaginateResources($levels);
    }

    public function singleLevel(UserSubscriber $userSubscriber, Request $request)
    {
        $levels = LevelsUser::query()->orderByDesc('created_at')->with('levelGift')
            ->where('user_id', $userSubscriber->id)
            ->when($request->get('level_id'), function ($query, $level) {
                $query->where('level_id', (integer)$level);
            })->when($request->get('type'), function ($query, $type) {
                $query->whereHas('levelGift', function ($query) use ($type) {
                    $query->where('type', $type);
                });
            })->paginate($this->perPage);

        return new LevelsUsersPaginateResources($levels);
    }

}
