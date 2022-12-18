<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\Role\ActionsListResources;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use App\Policies\RolePolicy;
use http\Env\Response;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize(RolePolicy::VIEW, Role::class);

        $role = Role::all();

        return  RoleResource::collection($role)->all();
    }

    public function store(RoleRequest $request)
    {
        $this->authorize(RolePolicy::CREATE, Role::class);

        $role = Role::create([
            'name' => $request->input('name'),
            'permission' => $request->input('permission')
        ]);

        return (new RoleResource($role))->response()->setStatusCode(201);
    }

    public function update(Role $role,RoleRequest $request)
    {

        if ($request->isMethod('get')) {

            $this->authorize(RolePolicy::VIEW, Role::class);

            return new RoleResource($role);
        }

        $this->authorize(RolePolicy::UPDATE, Role::class);

        $role->update([
           'name' => $request->input('name'),
           'permission' => $request->input('permission')
        ]);

        return (new RoleResource($role))->response()->setStatusCode(202);
    }

    public function destroy(Role $role){

        $this->authorize(RolePolicy::DELETE, Role::class);

        $role->delete();

        return response()->json()->setStatusCode(204);
    }

    public function permissions()
    {
        return new ActionsListResources('actions');
    }
}
