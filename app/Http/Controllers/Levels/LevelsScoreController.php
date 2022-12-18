<?php

namespace App\Http\Controllers\Levels;

use App\Http\Controllers\Controller;
use App\Policies\LevelsScorePolicy;
use Illuminate\Http\Request;
use Usoft\Levels\Models\Level;
use Usoft\Levels\Models\LevelsScore;
use Usoft\Levels\Requests\LevelsScoreRequest;
use Usoft\Levels\Resources\LevelsScoreResources;

class LevelsScoreController extends Controller
{
    public function index(Level $level)
    {
        $this->authorize(LevelsScorePolicy::VIEW, LevelsScore::class);

        if (!empty($level->id)){
            $levelsScore = LevelsScore::where('level_id', $level->id)->get();
        }else
            $levelsScore = LevelsScore::all();

        return LevelsScoreResources::collection($levelsScore)->all();
    }

    public function store(Level $level,LevelsScoreRequest $request)
    {
        $this->authorize(LevelsScorePolicy::CREATE, LevelsScore::class);
        $level = LevelsScore::create([
            'score' => $request->input('score'),
            'level_id' => $level->id,
            'step' => $request->input('step')
        ]);

        return (new LevelsScoreResources($level))->response()->setStatusCode(201);
    }

    public function update(Level $level,LevelsScore $levelsScore, LevelsScoreRequest $request)
    {

        if ($request->isMethod('get')) {

            $this->authorize(LevelsScorePolicy::VIEW, LevelsScore::class);

            return new LevelsScoreResources($levelsScore);
        }

        $this->authorize(LevelsScorePolicy::UPDATE, LevelsScore::class);

        $levelsScore->update([
            'score' => $request->input('score'),
            'level_id' => $request->input('level_id'),
            'step' => $request->input('step')
        ]);

        return (new LevelsScoreResources($levelsScore))->response()->setStatusCode(202);
    }

    public function destroy(Level $level,LevelsScore $levelsScore)
    {
        $this->authorize(LevelsScorePolicy::DELETE, LevelsScore::class);

        $levelsScore->delete();

        return response()->json()->setStatusCode(204);
    }
}
