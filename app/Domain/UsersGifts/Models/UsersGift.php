<?php

namespace Usoft\UsersGifts\Models;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Usoft\Gifts\Models\Gift;
use Usoft\UserSubscribers\Models\UserSubscriber;

class UsersGift extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'users_gifts_database';

    protected $table = 'users_gifts';

    protected $casts = [
        'game' => 'boolean',
        'premium' => 'boolean',
        'step' => 'integer',
        'price' => 'double',
    ];

    public function gift()
    {
        return $this->hasOne(Gift::class, 'id', 'gift_id');
    }

    public function subscriber()
    {
        return $this->hasOne(UserSubscriber::class, 'id', 'user_id');
    }

}
