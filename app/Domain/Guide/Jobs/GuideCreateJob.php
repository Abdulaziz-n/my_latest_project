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

class GuideCreateJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GuideRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function handle()
    {
        $items = Guide::query()->orderBy('position', 'asc')->get();
        $items_count = Guide::count();


        if ($this->request->image) {
            $image = $this->request->file('image')->store('images', 's3');
            Storage::disk('s3')->setVisibility($image, 'public');
            $path = Storage::disk('s3')->url($image);
        }

        return Guide::query()->create([
            'title' => $this->request->input('title'),
            'body' => $this->request->input('body'),
            'image' => $path ?? null,
            'position' => $this->request->input('position') ?? $items_count + 1,
        ]);

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

    }

}
