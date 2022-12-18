<?php

namespace Usoft\Levels\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;

    protected $connection = 'levels_pgsql';

    protected $table = 'levels';

    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'array'
    ];

}
