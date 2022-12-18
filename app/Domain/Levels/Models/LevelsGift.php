<?php

namespace Usoft\Levels\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Usoft\Levels\Models\Level;


class LevelsGift extends Model
{
    use SoftDeletes;

    protected $connection = 'levels_pgsql';

    protected $table = 'levels_gifts';

    protected $casts = [
        'name' => 'array',
        'amount' => 'integer',
        'probability' => 'integer'
    ];

    protected $guarded = ['id'];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }


    public function getImage()
    {
        return Storage::disk('s3')->temporaryUrl($this->image, Carbon::now()->addDays(1));
    }
}
