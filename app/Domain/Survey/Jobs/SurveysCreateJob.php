<?php

namespace Usoft\Survey\Jobs;

use Usoft\Survey\Models\Survey;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SurveysCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $organization;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($organization,$request)
    {
        $this->request = $request;
        $this->organization = $organization;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $survey_id = Survey::query()->where('uuid', $this->request->input('dependent_survey_id'))->value('id');

        $survey = Survey::query()->create([
            'organization_id' => $this->organization->id,
            'name' => $this->request->input('name'),
            'is_draft' => $this->request->input('is_draft'),
            'position' => $this->request->input('position'),
            'dependent_survey_id' => $survey_id,
            'is_dependent' => $this->request->input('is_dependent')
        ]);

        return $survey;
    }
}
