<?php

namespace Usoft\InputType\Jobs;

use App\Http\Resources\InputType\InputTypeResource;
use Usoft\InputType\Models\InputType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InputTypeCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type = InputType::query()->create([
            'name' => $this->request->input('name'),
            'type' => $this->request->input('type')
        ]);

        return $type;
    }
}
