<?php

namespace Usoft\Gifts\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Usoft\Categories\Models\Category;


class Gift extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'gifts_pgsql';

    protected $casts = [
        'name' => 'array',
        'package_id' => 'integer',
        'published' => 'boolean',
        'first_prize' => 'boolean',
        'super_prize' => 'boolean',
        'type' => 'string',
        'premium' => 'boolean',
        'sticker_id' => 'string',
        'values' => 'integer',
        'price' => 'integer',

    ];


}
