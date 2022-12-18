<?php

namespace Usoft\Survey\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Survey\Models\Survey;

class SurveysUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $survey;
    protected $organization;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($organization, $request, $survey)
    {
        $this->request = $request;
        $this->survey = $survey;
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

        $this->survey->update([
            'uuid' => $this->survey->uuid,
            'organization_id' => $this->organization->id,
            'name' => $this->request->input('name'),
            'is_draft' => $this->request->input('is_draft'),
            'position' => $this->request->input('position'),
            'dependent_survey_id' => $survey_id ?? null,
            'is_dependent' => $this->request->input('is_dependent')
        ]);

        return $this->survey;
    }
}
