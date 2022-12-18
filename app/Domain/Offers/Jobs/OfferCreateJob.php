<?php

namespace Usoft\Offers\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Offers\Models\Offer;
use Usoft\Offers\Requests\OfferRequest;

class OfferCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OfferRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        return Offer::create([
            'name' => $this->request->input('name'),
            'offer_id' => $this->request->input('offer_id'),
            'types' => $this->request->input('types'),
        ]);

    }

}
