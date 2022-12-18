<?php

namespace Usoft\Organization\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrganizationUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $organization;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $organization)
    {
        $this->organization = $organization;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $organization = $this->organization->update([
            'name' => $this->request->input('name'),
//            'uuid' => $this->organization->uuid
        ]);
        return $organization;
    }
}
