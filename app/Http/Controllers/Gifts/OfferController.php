<?php

namespace App\Http\Controllers\Gifts;

use App\Policies\OfferPolicy;
use Usoft\Offers\Jobs\OfferCreateJob;
use Usoft\Offers\Jobs\OfferUpdateJob;
use Usoft\Offers\Resources\OfferResources;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Usoft\Gifts\Models\Gift;
use Usoft\Offers\Models\Offer;
use Usoft\Offers\Requests\OfferRequest;

class OfferController extends Controller
{
    public function index()
    {
        $this->authorize(OfferPolicy::VIEW, Offer::class);

        $offer = Offer::all();

        return  OfferResources::collection($offer)->all();
    }

    public function store(OfferRequest $request)
    {
        $this->authorize(OfferPolicy::CREATE, Offer::class);

        $offer = OfferCreateJob::dispatchNow($request);

        return (new OfferResources($offer))->response()->setStatusCode(201);
    }

    public function update(Offer $offer,OfferRequest $request)
    {
        if ($request->isMethod('get')) {

            $this->authorize(OfferPolicy::VIEW,Offer::class);

            return new OfferResources($offer);
        }

        $this->authorize(OfferPolicy::UPDATE, Offer::class);

        OfferUpdateJob::dispatchNow($request, $offer);

        $offer->refresh();

        return (new OfferResources($offer))->response()->setStatusCode(202);
    }

    public function destroy(Offer $offer){

        $this->authorize(OfferPolicy::DELETE, Offer::class);

        $offer->delete();

        return response()->json()->setStatusCode(204);
    }
}
