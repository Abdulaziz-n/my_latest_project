<?php

namespace App\Http\Controllers\Gifts;

use Usoft\Gifts\Jobs\GiftsUpdateJob;
use Usoft\Gifts\Jobs\GiftsCreateJobs;
use Usoft\Gifts\Resources\GiftResources;
use App\Http\Controllers\Controller;
use App\Policies\GiftPolicy;
use Illuminate\Http\Request;
use Usoft\Gifts\Models\Gift;
use Usoft\Gifts\Requests\GiftRequest;


class GiftController extends Controller
{
    public function index()
    {
        $this->authorize(GiftPolicy::VIEW, Gift::class);

        $gift = Gift::all();

        return  GiftResources::collection($gift)->all();
    }

    public function store(GiftRequest $request)
    {
        $this->authorize(GiftPolicy::CREATE, Gift::class);

        $gift = GiftsCreateJobs::dispatchNow($request);

        return (new GiftResources($gift))->response()->setStatusCode(201);
    }

    public function update(Gift $gift,GiftRequest $request)
    {
        if ($request->isMethod('get')) {

            $this->authorize(GiftPolicy::VIEW, Gift::class);

            return new GiftResources($gift);
        }

        $this->authorize(GiftPolicy::UPDATE, Gift::class);

        GiftsUpdateJob::dispatchNow($request, $gift);

        $gift->refresh();

        return (new GiftResources($gift))->response()->setStatusCode(202);
    }

    public function destroy(Gift $gift){

        $this->authorize(GiftPolicy::DELETE, Gift::class);

        $gift->delete();

        return response()->json()->setStatusCode(204);
    }
}
