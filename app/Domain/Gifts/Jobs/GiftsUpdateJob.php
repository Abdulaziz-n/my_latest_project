<?php

namespace Usoft\Gifts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Gifts\Models\Gift;
use Usoft\Gifts\Requests\GiftRequest;

class GiftsUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    protected $gift;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GiftRequest $request, Gift $gift)
    {
        $this->request = $request;
        $this->gift = $gift;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {

        $data = $this->gift->query()->update([
            'name' => $this->request->input('name'),
            'package_id' => $this->request->input('package_id'),
            'published' => $this->request->input('published'),
            'first_prize' => $this->request->input('first_prize'),
            'super_prize' => $this->request->input('super_prize'),
            'type' => $this->request->input('type'),
            'premium' => $this->request->input('premium'),
            'sticker_id' => $this->request->input('sticker_id'),
            'values' => $this->request->input('values'),
            'price' => $this->request->input('price'),
        ]);
        return $data;
    }
}
