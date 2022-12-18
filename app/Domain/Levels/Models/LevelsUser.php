<?php

namespace Usoft\Levels\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Usoft\UserSubscribers\Models\UserSubscriber;

class LevelsUser extends Model
{
   protected $collection = 'level_gifts_users';
   protected $connection = 'levels_users_database';
//    protected $table = 'levels_users';

    protected $casts = [
        'user_id' => 'integer',
        'level_gift_id' => 'integer',
        'level_id' => 'integer',
    ];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(UserSubscriber::class, 'user_id', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function levelGift()
    {
        return $this->belongsTo(LevelsGift::class, 'level_gift_id', 'id');
    }
}
