<?php

namespace Usoft\Levels\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelsScore extends Model
{
    use SoftDeletes;

    protected $connection = 'levels_pgsql';

    protected $table = 'levels_scores';

    protected $guarded = ['id'];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
