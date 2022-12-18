<?php

namespace Usoft\Categories\Jobs;

use Usoft\Categories\Requests\CategoryRequest;
use Usoft\Categories\Resources\CategoryResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Categories\Models\Category;

class CategoryJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CategoryRequest $request)
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
        $category = Category::query()->create([
            'name' => $this->request->input('name'),
            'type' => $this->request->input('type'),
            'packages' => $this->request->input('packages'),
            'step' => $this->request->input('step'),
            'last_package_id' => $this->request->input('last_package_id'),
        ]);

        $category->gifts()->attach($this->request->input('gift_id'));

        return $category;
    }

}
