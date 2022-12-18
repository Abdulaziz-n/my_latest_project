<?php

namespace Usoft\Guide\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Usoft\Guide\Models\Guide;
use Usoft\Guide\Requests\GuideRequest;

class GuideUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    protected $guide;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GuideRequest $request, Guide $guide)
    {
        $this->request = $request;
        $this->guide = $guide;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        if ($this->request->image) {
            $image = $this->request->file('image')->store('images', 's3');
            Storage::disk('s3')->setVisibility($image, 'public');
            $path = Storage::disk('s3')->url($image);
        } else
            $image = $this->guide->image;

        $this->guide->update([
            'title' => $this->request->input('title'),
            'body' => $this->request->input('body'),
            'image' => $path ?? $image,
            'position' => $this->request->input('position'),
        ]);


    }

}
