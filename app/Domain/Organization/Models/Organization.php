<?php

namespace Usoft\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'questionnaire_pgsql';

    protected $casts = [
        'name' => 'string',
        'uuid' => 'string'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        self:: creating (function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
