<?php

namespace App\Domain\Social\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Usoft\Social\Models\Social;
use Usoft\Social\Requests\SocialRequest;

class SocialCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SocialRequest $request)
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
        $items = Social::all();
        $items_count = Social::count();

        $c = $this->request->post('position');
        if ($this->request->position) {
            foreach ($items as $item) {
                if ($item->position >= $this->request->position) {
                    $c++;
                    $item->update([
                        'position' => $c
                    ]);
                }
            }
        }

        return Social::create([
            'title' => $this->request->input('title'),
            'type' => $this->request->input('type'),
            'position' => $this->request->input('position') ?? $items_count + 1,
            'url' => $this->request->input('url'),
        ]);
    }

}
