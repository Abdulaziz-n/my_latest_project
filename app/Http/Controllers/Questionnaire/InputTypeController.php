<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use Usoft\InputType\Requests\InputTypeRequest;
use Usoft\InputType\Resources\InputTypeResource;
use Usoft\InputType\Jobs\InputTypeCreateJob;
use Usoft\InputType\Jobs\InputTypeUpdateJob;
use Usoft\InputType\Models\InputType;
use Illuminate\Http\Request;

class InputTypeController extends Controller
{
    public function index()
    {
        $input = InputType::query()->get();

        return InputTypeResource::collection($input)->all();
    }

    public function store(InputTypeRequest $request)
    {
        $input = InputTypeCreateJob::dispatchNow($request);

        return (new InputTypeResource($input))->response();
    }

    public function update(InputType $inputType, InputTypeRequest $request)
    {
        if ($request->isMethod('get'))
            return new InputTypeResource($inputType);

        InputTypeUpdateJob::dispatchNow($request, $inputType);

        $inputType->refresh();

        return  new InputTypeResource($inputType);
    }

    public function destroy(InputType $inputType)
    {
        $inputType->delete();

        return response()->json()->setStatusCode(204);
    }
}
