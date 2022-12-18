<?php

namespace Usoft\Offers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'gifts_pgsql';

    protected $casts = [
        'types' => 'array'
    ];
}
