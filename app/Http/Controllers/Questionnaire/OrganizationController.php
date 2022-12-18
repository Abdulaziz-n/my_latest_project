<?php

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use Usoft\Organization\Requests\OrganizationRequest;
use Usoft\Organization\Resources\OrganizationResource;
use Usoft\Organization\Jobs\OrganizationCreateJob;
use Usoft\Organization\Jobs\OrganizationUpdateJob;
use Usoft\Organization\Models\Organization;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Usoft\Resources\ErrorResources;

class OrganizationController extends Controller
{
    public function index()
    {
        $organization = Organization::query()->get();

        return OrganizationResource::collection($organization)->all();
    }

    public function store(OrganizationRequest $request)
    {
        try {
            $organization = OrganizationCreateJob::dispatchNow($request);
        } catch (\Exception $exception) {
            return (new ErrorResources($exception))->response()->setStatusCode(403);
        }

        return new OrganizationResource($organization);
    }

    public function update(Organization $organization, OrganizationRequest $request)
    {
        if ($request->isMethod('get'))
            return new OrganizationResource($organization);

        try {
            OrganizationUpdateJob::dispatchNow($request, $organization);
        }catch (\Exception $exception){
            return (new ErrorResources($exception))->response()->setStatusCode(403);
        }

        $organization->refresh();

        return new OrganizationResource($organization);
    }

    public function destroy(Organization $organization)
    {

        $organization->delete();

        return response()->json()->setStatusCode('204');
    }

}
