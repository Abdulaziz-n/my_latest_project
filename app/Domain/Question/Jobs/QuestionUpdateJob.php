<?php

namespace Usoft\Question\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Usoft\Answer\Models\Answer;

class QuestionUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $question;
    protected $survey;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($survey,$request, $question)
    {
        $this->request = $request;
        $this->question = $question;
        $this->survey = $survey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->question->update([
            'name' => $this->request->input('name'),
            'hint' => $this->request->input('hint'),
            'survey_id' => $this->survey->id,
            'award_coins' => $this->request->input('award_coins'),
            'position' => $this->request->input('position'),
            'input_type_id' => $this->request->input('input_type_id'),
            'is_draft' => $this->request->input('is_draft'),
            'is_multiple' => $this->request->input('is_multiple'),
            'is_required' => $this->request->input('is_required'),
            'timer' => $this->request->input('timer')
        ]);

        foreach ($this->request->answers as $item){

            Answer::query()->where('question_id', $this->question->id)->updateOrCreate(
                [
                   'uuid' => $item['uuid']
                ],
                [
                'name' => $item['name'],
                'hint' => $item['hint'],
                'question_id' => $this->question->id,
                'position' => $item['position']
                ]
            );
        }

        return $this->question;
    }
}
