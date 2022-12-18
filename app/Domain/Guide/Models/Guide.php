<?php

namespace Usoft\Guide\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $connection = 'information_pgsql';

    protected $guarded = ['id'];

    protected $casts = [
        'title' => 'array',
        'body' => 'array'
    ];
}

