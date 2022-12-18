<?php

namespace Usoft\Policy\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Policy\Models\Policy;
use Usoft\Policy\Requests\PolicyRequest;

class PolicyUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $policy;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PolicyRequest $request, Policy $policy)
    {
        $this->request = $request;
        $this->policy = $policy;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        return $this->policy->update([
            'name' => $this->request->input('name'),
            'content' => $this->request->input('content')
        ]);

    }
}
