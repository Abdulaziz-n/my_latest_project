<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserRolesResource;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Support\Facades\Gate;
use Usoft\UsersDashboard\Jobs\UserStoreJob;
use Usoft\UsersDashboard\Jobs\UserUpdateJob;


class UserController extends Controller
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize(UserPolicy::VIEW, User::class);

        $user = User::all();
        return UserResource::collection($user)->all();
    }

    public function store(UserRequest $request)
    {
        $this->authorize(UserPolicy::CREATE, User::class);

        $user = UserStoreJob::dispatchNow($request);

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function update(User $user,UserUpdateRequest $request){

        if ($request->isMethod('get')) {

            $this->authorize(UserPolicy::VIEW, User::class);

            return new UserRolesResource($user);
        }

        $this->authorize(UserPolicy::UPDATE, User::class);

        UserUpdateJob::dispatchNow($user, $request);

        $user->refresh();

        return (new UserResource($user))->response()->setStatusCode(202);
    }

    public function destroy(User $user){

        $this->authorize(UserPolicy::DELETE, User::class);

        $user->delete();

        return response()->json()->setStatusCode(204);
    }
}
