<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use Aws\OpenSearchService\Exception\OpenSearchServiceException;
use Usoft\Organization\Models\Organization;
use Usoft\Question\Requests\QuestionRequest;
use Usoft\Answer\Resources\AnswerResource;
use Usoft\Question\Resources\QuestionResource;
use Usoft\Question\Jobs\QuestionCreateJob;
use Usoft\Question\Jobs\QuestionUpdateJob;
use Usoft\Answer\Models\Answer;
use Usoft\Question\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Usoft\Resources\ErrorResources;
use Usoft\Survey\Models\Survey;

class QuestionController extends Controller
{
    public function index(Organization $organization,Survey $survey)
    {
        $question = Question::query()->where('survey_id', $survey->id)->with('answers')->get();

        return QuestionResource::collection($question)->all();
    }

    public function store(Organization $organization, Survey $survey, Request $request)
    {
        try {
            $question = QuestionCreateJob::dispatchNow($survey, $request);
        } catch (\Exception $exception) {
            return (new ErrorResources($exception))->response()->setStatusCode(403);
        }

        return new QuestionResource($question);
    }

    public function update(Organization $organization, Survey $survey, Question $question, Request $request)
    {

        if ($request->isMethod('get'))
            return new QuestionResource($question);

        try {
            QuestionUpdateJob::dispatchNow($survey, $request, $question);
        } catch (\Exception $exception) {
            return (new ErrorResources($exception))->response()->setStatusCode(403);
        }

        $question->refresh();

        return new QuestionResource($question);
    }

    public function destroy(Organization $organization, Survey $survey, Question $question)
    {
        $question->delete();

        return response()->json()->setStatusCode(204);
    }

    public function deleteAnswer(Organization $organization, Survey $survey, Question $question, Answer $answer)
    {
        $answer->delete();

        return response()->json()->setStatusCode(204);
    }


    public function updatePosition(Organization $organization, Survey $survey, Question $question, Request $request)
    {
        $items = Question::query()->where('position', '>=', $request->position)->get();

        $question->where('position', '>=', $request->position)->increment('position');

        $items = Question::query()->get();

        return $items;

        $c = $request->post('position');

        if ($request->position) {
            $question->update([
                'position' => $request->position
            ]);
            foreach ($items as $item) {
                if ($item->position >= $request->position) {
                    $c++;
                    $item->update([
                        'position' => $c
                    ]);
                }
            }
        }

        return (new QuestionResource($question))->response()->setStatusCode(202);
    }
}
