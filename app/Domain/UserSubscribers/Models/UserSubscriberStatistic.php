<?php

namespace Usoft\UserSubscribers\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriberStatistic extends Model
{
    protected $connection = 'main';

    protected $table = 'subscriber_statistics';

    protected $guarded = ['id'];

    protected $casts = [
        'count' => 'integer'
    ];
}
