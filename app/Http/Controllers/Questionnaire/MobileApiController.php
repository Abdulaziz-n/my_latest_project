<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Usoft\Answer\Models\Answer;
use Usoft\AnswersUser\Models\AnswersUser;
use Usoft\MobileApi\Resources\Question\MobileApiQuestionResource;
use Usoft\MobileApi\Resources\Question\MobileQuestionResource;
use Usoft\Question\Models\Question;
use Usoft\Question\Resources\QuestionApiResource;
use Usoft\Survey\Models\Survey;

class MobileApiController extends Controller
{
    public function question(Request $request)
    {
        $user_id = 12;

        $survey = $this->answer($user_id);

        return $survey;
        if ($survey == null){

            return response()->json()->setStatusCode(404);
        }

        $question = Survey::query()->with('questions')->where('uuid', $survey) ->get();

        return MobileApiQuestionResource::collection($question)->all();
    }

    public function answer($user_id)
    {

        $answer = AnswersUser::query()->orderBy('created_at', 'DESC')->where('user_id', $user_id)->get();

        if (empty($answer)){

            return response()->json('User not found')->setStatusCode(404);
        }

        $during_last_answer = $answer->whereBetween('created_at',[Carbon::today()->subDays(3), Carbon::today()->endOfDay()])->first();

        if (empty($during_last_answer)){

            return null;
        }

        $last_answer = $answer->first();

        return $last_answer;
    }

    public function answerUser(Request $request)
    {
        $answer = AnswersUser::query()->create([
           'user_id' => $request->input('user_id'),
            'organization_id' => $request->input('organization_id'),
            'survey_id' => $request->input('survey_id'),
            'question_id' => $request->input('question_id'),
            'answer_id' => $request->input('answer_id')
        ]);

        return $answer;
    }

    public function mockApi()
    {
        return [
            "questions" => [
                [
                    "uuid" => "6067e2b2-03be-4ff0-8db6-e4d00c1422a3",
                    "name" => "Necha Yoshda siz ?",
                    "hint" => "hint",
                    "award_coins" => 2,
                    "input_type" => [
                        "id" => 2,
                        "name" => "radio",
                        "type" => "radio"
                    ],
                    "is_multiple" => false,
                    "is_required" => true,
                    "timer" => 10,
                    "answers" => [
                        [
                            "uuid" => "16dd22ae-e0aa-4ff6-9763-32cd1c4a1eb1",
                            "name" => "16-25",
                            "hint" => null
                        ],
                        [
                            "uuid" => "d1d98581-6c14-430a-b71e-6e820f38a782",
                            "name" => "35-40",
                            "hint" => null
                        ]
                    ]
                ],
                [
                    "uuid" => "534a6431-9106-429d-9fe6-2b3ba104f8b3",
                    "name" => "Oltin Baliq uchun ortacha qancha mablag sarflaysiz 1 oyda ?",
                    "hint" => "hint",
                    "award_coins" => 2,
                    "input_type" => [
                        "id" => 2,
                        "name" => "checkbox",
                        "type" => "checkbox"
                    ],
                    "is_multiple" => true,
                    "is_required" => true,
                    "timer" => 10,
                    "answers" => [
                        [
                            "uuid" => "97b926e0-d493-405b-ad02-7986a8abfc02",
                            "name" => "5000 - 25000",
                            "hint" => null
                        ],
                        [
                            "uuid" => "97b926e0-d493-405b-ad02-7986a8abfc02",
                            "name" => "25000 - 60000",
                            "hint" => null
                        ],
                        [
                            "uuid" => "40ed4572-b983-42c7-bb17-da539a1f08c1",
                            "name" => "60000 - 100000",
                            "hint" => null
                        ]
                    ]
                ]
            ]
        ];
    }
}

