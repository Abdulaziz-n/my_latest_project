<?php

namespace Usoft\Offers\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Offers\Models\Offer;
use Usoft\Offers\Requests\OfferRequest;


class OfferUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $offer;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OfferRequest $request, Offer $offer)
    {
        $this->request = $request;
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        return $this->offer->update([
            'name' => $this->request->input('name'),
            'offer_id' => $this->request->input('offer_id'),
            'types' => $this->request->input('types'),
        ]);

    }

}
