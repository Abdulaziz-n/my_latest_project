<?php

namespace App\Http\Controllers\Informations;

use App\Policies\PolicyPolicy;
use Usoft\Policy\Jobs\PolicyUpdateJob;
use Usoft\Policy\Requests\PolicyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Usoft\Policy\Models\Policy;
use App\Domain\Policy\Resources\PolicyResource;

class PolicyController extends Controller
{
    public function index()
    {
        $this->authorize(PolicyPolicy::VIEW, Policy::class);

        $role = Policy::find(1);

        return  (new PolicyResource($role))->response()->setStatusCode(200);
    }

//    public function store(PolicyRequest $request)
//    {
//        $this->authorize(PolicyPolicy::CREATE, Policy::class);
//
//        $role = Policy::create([
//            'name' => $request->input('name'),
//            'content' => $request->input('content')
//        ]);
//
//        return (new PolicyResource($role))->response()->setStatusCode(201);
//    }

    public function update(Policy $policy,PolicyRequest $request)
    {
        if ($request->isMethod('get')) {

            $this->authorize(PolicyPolicy::VIEW, Policy::class);

            return new PolicyResource($policy);
        }

        PolicyUpdateJob::dispatchNow($request,$policy);

        $policy->refresh();

        return (new PolicyResource($policy))->response()->setStatusCode(202);
    }

    public function destroy(Policy $policy){

        $this->authorize(PolicyPolicy::DELETE, Policy::class);

        $policy->delete();

        return response()->json()->setStatusCode(204);
    }
}
