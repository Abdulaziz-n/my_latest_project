<?php

namespace App\Http\Controllers\Levels;

use Usoft\Levels\Requests\LevelsRequest;
use Usoft\Levels\Resources\LevelsResources;
use App\Http\Controllers\Controller;
use App\Policies\LevelsPolicy;
use Illuminate\Http\Request;
use Usoft\Levels\Models\Level;

class LevelController extends Controller
{

    public function index()
    {
        $this->authorize(LevelsPolicy::VIEW, Level::class);

        $level = Level::query()->orderBy('id', 'ASC')->get();

        return LevelsResources::collection($level)->all();
    }

    public function store(LevelsRequest $request)
    {
        $this->authorize(LevelsPolicy::CREATE, Level::class);

        $level = Level::create([
            'name' => $request->input('name'),
            'score' => $request->input('score')
        ]);

        return (new LevelsResources($level))->response()->setStatusCode(201);
    }

    public function update(Level $level, LevelsRequest $request)
    {

        if ($request->isMethod('get')) {

            $this->authorize(LevelsPolicy::VIEW, Level::class);

            return new LevelsResources($level);
        }

        $this->authorize(LevelsPolicy::UPDATE, Level::class);

        $level->update([
            'name' => $request->input('name'),
            'score' => $request->input('score')
        ]);

        return (new LevelsResources($level))->response()->setStatusCode(202);
    }

    public function destroy(Level $level)
    {
        $this->authorize(LevelsPolicy::DELETE, Level::class);

        $level->delete();

        return response()->json()->setStatusCode(204);
    }
}
