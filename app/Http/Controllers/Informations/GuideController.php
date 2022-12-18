<?php

namespace App\Http\Controllers\Informations;

use Usoft\Guide\Jobs\GuideUpdateJob;
use Usoft\Guide\Jobs\GuideCreateJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Policies\GuidePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Utils;
use Usoft\Guide\Models\Guide;
use Usoft\Guide\Requests\GuideRequest;
use Usoft\Guide\Resources\GuideResources;

class GuideController extends Controller
{
    public function index()
    {
        $this->authorize(GuidePolicy::VIEW, Guide::class);

        $guide = Guide::query()->orderBy('position', 'DESC')->get();

        return GuideResources::collection($guide)->all();
    }

    public function store(GuideRequest $request)
    {
        $this->authorize(GuidePolicy::CREATE, Guide::class);

        $guide = GuideCreateJob::dispatchNow($request);

        return (new GuideResources($guide))->response()->setStatusCode(201);
    }

    public function update(Guide $guide, GuideRequest $request)
    {
        if ($request->isMethod('get')) {
            $this->authorize(GuidePolicy::VIEW, Guide::class);
            return new GuideResources($guide);
        }

        $this->authorize(GuidePolicy::UPDATE, Guide::class);

        GuideUpdateJob::dispatchNow($request, $guide);

        $guide->refresh();

        return (new GuideResources($guide))->response()->setStatusCode(202);
    }

    public function updatePosition(Guide $guide, PositionRequest $request)
    {
        $items = Guide::query()->orderBy('position', 'DESC')->get();

        $c = $request->post('position');

        if ($request->position) {
            $guide->update([
                'position' => $request->position
            ]);
            foreach ($items as $item) {
                if ($item->position > $request->position) {
                    $c++;
                    $item->update([
                        'position' => $c
                    ]);
                }
            }
        }

        return (new GuideResources($guide))->response()->setStatusCode(202);
    }

    public function destroy(Guide $guide)
    {
        $this->authorize(GuidePolicy::DELETE, Guide::class);

        $guide->delete();

        return response()->json()->setStatusCode(204);
    }
}
