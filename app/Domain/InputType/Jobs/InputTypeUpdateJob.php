<?php

namespace Usoft\InputType\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InputTypeUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $inputType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $inputType)
    {
        $this->request = $request;
        $this->inputType = $inputType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inputType = $this->inputType->update([
            'name' => $this->request->input('name'),
            'type' => $this->request->input('type')
        ]);

        return $inputType;
    }
}
