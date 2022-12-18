<?php

namespace Usoft\ActivityLog\Models;

use App\Models\User;
use Jenssegers\Mongodb\Eloquent\Model;
use Usoft\UserSubscribers\Models\UserSubscriber;

class Log extends Model
{
    protected $connection = 'activity_log_mongodb';

    protected $table = 'logs';

    protected $guarded = ['id'];

    protected $casts = [
        'phone' => 'integer',
        'action' => 'string',
        'data' => 'array',
        'user_id' => 'integer',
    ];
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(UserSubscriber::class, 'user_id', 'id');
    }
}
