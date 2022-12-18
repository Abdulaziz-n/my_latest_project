<?php

namespace App\Http\Controllers\Informations;

use App\Policies\PrizePolicy;
use Usoft\Prize\Jobs\PrizeCreateJob;
use Usoft\Prize\Requests\PrizeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Usoft\Prize\Models\Prize;
use Usoft\Prize\Resources\PrizeResource;

class PrizeController extends Controller
{
    public function index()
    {
        $this->authorize(PrizePolicy::VIEW, Prize::class);

        $prize = Prize::find(1);

        return  (new PrizeResource($prize))->response()->setStatusCode(200);
    }

    public function store(PrizeRequest $request)
    {
        $this->authorize(PrizePolicy::CREATE, Prize::class);

        $prize = PrizeCreateJob::dispatchNow($request);

        return (new PrizeResource($prize))->response()->setStatusCode(201);
    }

//    public function update(PrizeRequest $prize,Request $request)
//    {
//        if ($request->isMethod('get')) {
//            return new PrizeResource($prize);
//        }
//
//        $prize->update([
//            'content_uz' => $request->input('content_uz'),
//            'content_ru' => $request->input('content_ru'),
//            'content_en' => $request->input('content_en'),
//        ]);
//
//        return (new PrizeResource($prize))->response()->setStatusCode(202);
//    }

    public function destroy(Prize $prize){

        $this->authorize(PrizePolicy::DELETE, Prize::class);

        $prize->delete();

        return response()->json()->setStatusCode(204);
    }
}
