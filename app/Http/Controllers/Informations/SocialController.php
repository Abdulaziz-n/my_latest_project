<?php

namespace App\Http\Controllers\Informations;

use App\Domain\Social\Jobs\SocialCreateJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Policies\SocialPolicy;
use Illuminate\Http\Request;
use Usoft\Social\Jobs\SocialUpdateJob;
use Usoft\Social\Models\Social;
use Usoft\Social\Requests\SocialRequest;
use Usoft\Social\Resources\SocialResource;

class SocialController extends Controller
{
    public function index()
    {
        $this->authorize(SocialPolicy::VIEW, Social::class);

        $social = Social::orderBy('position', 'asc')->get();

        return SocialResource::collection($social)->all();
    }

    public function store(SocialRequest $request)
    {
        $this->authorize(SocialPolicy::CREATE, Social::class);

        $social = SocialCreateJob::dispatchNow($request);

        return (new SocialResource($social))->response()->setStatusCode(201);
    }

    public function update(Social $social, SocialRequest $request)
    {
        if ($request->isMethod('get')) {

            $this->authorize(SocialPolicy::VIEW, Social::class);

            return new SocialResource($social);
        }

        $this->authorize(SocialPolicy::UPDATE, Social::class);

        SocialUpdateJob::dispatchNow($social,$request);

        $social->refresh();

        return (new SocialResource($social))->response()->setStatusCode(202);
    }

    public function updatePosition(Social $social, PositionRequest $request)
    {
        $items = Social::all();

        $c = $request->post('position');

        if ($request->position) {
            $social->update([
                'position' => $request->position
            ]);
            foreach ($items as $item) {
                if ($item->position >= $request->position) {
                    $c++;
                    $item->update([
                        'position' => + 1
                    ]);
                }
            }
        }

        return (new SocialResource($social))->response()->setStatusCode(202);
    }

    public function destroy(Social $social)
    {
        $this->authorize(SocialPolicy::DELETE, Social::class);

        $social->delete();

        return response()->json()->setStatusCode(204);
    }


}
