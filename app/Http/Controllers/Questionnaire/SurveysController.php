<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use Usoft\Organization\Models\Organization;
use Usoft\Resources\ErrorResources;
use Usoft\Survey\Requests\SurveyRequest;
use Usoft\Survey\Resources\SurveyResource;
use Usoft\Survey\Jobs\SurveysCreateJob;
use Usoft\Survey\Jobs\SurveysUpdateJob;
use Usoft\Survey\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveysController extends Controller
{
    public function index(Organization $organization)
    {
        $surveys = Survey::query()->where('organization_id', $organization->id)->get();

        return SurveyResource::collection($surveys)->all();
    }

    public function store(Organization $organization, SurveyRequest $request)
    {
        try {
            $survey = SurveysCreateJob::dispatchNow($organization, $request);
        } catch (\Exception $exception) {
            return (new ErrorResources($exception))->response()->setStatusCode(403);
        }

        return (new SurveyResource($survey))->response();
    }


    public function update(Organization $organization, Survey $survey, SurveyRequest $request)
    {
        if ($request->isMethod('get'))
            return new SurveyResource($survey);

        try {
            SurveysUpdateJob::dispatchNow($organization, $request, $survey);
        } catch (\Exception $exception) {
            return (new ErrorResources($exception))->response()->setStatusCode(403);
        }

        $survey->refresh();

        return new SurveyResource($survey);
    }

    public function destroy(Organization $organization, Survey $survey)
    {
        $survey->delete();

        return response()->json()->setStatusCode(204);
    }
}
