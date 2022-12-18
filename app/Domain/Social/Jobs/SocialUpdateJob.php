<?php

namespace Usoft\Social\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Social\Models\Social;
use Usoft\Social\Requests\SocialRequest;

class SocialUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    protected $social;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Social $social, SocialRequest $request)
    {
        $this->request = $request;
        $this->social = $social;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        $this->social->update([
            'title' => $this->request->input('title'),
            'type' => $this->request->input('type'),
            'position' => $this->request->input('position'),
            'url' => $this->request->input('url'),
        ]);
    }

}
