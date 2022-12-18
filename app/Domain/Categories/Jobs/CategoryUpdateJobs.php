<?php

namespace Usoft\Categories\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Categories\Models\Category;
use Usoft\Categories\Requests\CategoryRequest;

class CategoryUpdateJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    protected $category;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CategoryRequest $request, Category $category)
    {
        $this->request = $request;
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->category->gifts()->sync($this->request->input('gift_id'));

        return $this->category->update([
            'name' => $this->request->input('name'),
            'type' => $this->request->input('type'),
            'packages' => $this->request->input('packages'),
            'step' => $this->request->input('step'),
            'last_package_id' => $this->request->input('last_package_id'),
        ]);
    }
}
