<?php

namespace Usoft\Prize\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Prize\Models\Prize;
use Usoft\Prize\Requests\PrizeRequest;

class PrizeCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PrizeRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        return Prize::create([
            'content_uz' => $this->request->input('content_uz'),
            'content_ru' => $this->request->input('content_ru'),
            'content_en' => $this->request->input('content_en'),
        ]);

    }
}
