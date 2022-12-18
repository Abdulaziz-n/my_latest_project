<?php

namespace Usoft\Policy\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $connection = 'information_pgsql';
    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'array',
        'content' => 'array'
    ];
}
