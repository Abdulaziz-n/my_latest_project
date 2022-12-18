<?php

namespace Usoft\UsersGifts\Models;

use Illuminate\Database\Eloquent\Model;

class UserGiftsStatistics extends Model
{
    protected $connection = 'main';

    protected $table  = 'gifts_statistics';

    protected $guarded = ['id'];

    protected $casts = [
      'count' => 'integer'
    ];
}
