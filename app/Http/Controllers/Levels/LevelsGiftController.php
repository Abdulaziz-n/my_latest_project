<?php

namespace App\Http\Controllers\Levels;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Policies\LevelsGiftsPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Usoft\Levels\Models\Level;
use Usoft\Levels\Models\LevelsGift;
use Usoft\Levels\Requests\LevelsGiftsRequest;
use Usoft\Levels\Resources\LevelsGiftsResources;

class LevelsGiftController extends Controller
{
    public function index(Level $level)
    {
        $this->authorize(LevelsGiftsPolicy::VIEW, LevelsGift::class);

        if (!empty($level->id)){
            $levelsGift = LevelsGift::where('level_id', $level->id)->get();
        }else
            $levelsGift = LevelsGift::all();

        return LevelsGiftsResources::collection($levelsGift)->all();
    }

    public function store(Level $level, LevelsGiftsRequest $request)
    {
        $this->authorize(LevelsGiftsPolicy::CREATE, LevelsGift::class);

        $image = $request->file('image')->store('images', 's3');
        Storage::disk('s3')->setVisibility($image, 'public');

        $items = LevelsGift::query()->orderBy('position', 'asc')->get();
        $items_count = LevelsGift::count();

        $c = $request->post('position');
        if ($request->position) {
            foreach ($items as $item) {
                if ($item->position >= $request->position) {
                    $c++;
                    $item->update([
                        'position' => $c
                    ]);
                }

            }
        }

        $levelsGift = LevelsGift::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'amount' => $request->input('amount') ?? null,
            'package_id' => $request->input('package_id'),
            'level_id' => $level->id,
            'published' => $request->input('published'),
            'count' => $request->input('count'),
            'image' => $image,
            'position' => $request->input('position') ?? $items_count + 1,
            'count_draft' => $request->input('count_draft'),
            'probability' => $request->input('probability')
        ]);

        return (new LevelsGiftsResources($levelsGift))->response()->setStatusCode(201);
    }

    public function update(Level $level, LevelsGift $levelsGift, LevelsGiftsRequest $request)
    {

        if ($request->isMethod('get')) {
            $this->authorize(LevelsGiftsPolicy::VIEW, LevelsGift::class);

            return new LevelsGiftsResources($levelsGift);
        }

        $this->authorize(LevelsGiftsPolicy::UPDATE, LevelsGift::class);

        if ($request->image) {
            $img = $request->file('image')->store('images', 's3');
            Storage::disk('s3')->setVisibility($img, 'public');
//            $img = Storage::disk('s3')->url($img);
        } else
            $img = $levelsGift->image;

        $levelsGift->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'amount' => $request->input('amount') ?? null,
            'package_id' => $request->input('package_id'),
            'level_id' => $level->id,
            'published' => $request->input('published'),
            'count' => $request->input('count'),
            'image' => $img,
            'position' => $request->input('position'),
            'count_draft' => $request->input('count_draft'),
            'probability' => $request->input('probability')
        ]);

        return (new LevelsGiftsResources($levelsGift))->response()->setStatusCode(202);
    }

    public function updatePosition(LevelsGift $level, PositionRequest $request)
    {
        $items = LevelsGift::query()->orderBy('position', 'asc')->get();

        $c = $request->post('position');

        if ($request->position) {
            $level->update([
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

        return (new LevelsGiftsResources($level))->response()->setStatusCode(202);
    }

    public function updateProbability(Level $level, LevelsGift $levelsGift, Request $request)
    {
        $levelsGift->update([
           'probability' => $request->get('probability')
        ]);

        return (new LevelsGiftsResources($levelsGift))->response()->setStatusCode(202);
    }


    public function destroy(Level $level,LevelsGift $levelsGift)
    {
        $this->authorize(LevelsGiftsPolicy::DELETE, LevelsGift::class);

        $levelsGift->delete();

        return response()->json()->setStatusCode(204);
    }
}
