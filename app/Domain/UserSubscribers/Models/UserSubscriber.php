<?php

namespace Usoft\UserSubscribers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Usoft\ActivityLog\Models\Log;

class UserSubscriber extends Model
{
    use SoftDeletes;

    protected $connection = 'users_pgsql';

    protected $table = 'users';

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'phone' => 'integer',
        'verify_code' => 'integer',
        'verified' => 'boolean',
        'stop' => 'boolean',
        'business' => 'boolean',
        'first_prize' => 'boolean',
        'prize' => 'boolean',
        'language' => 'string',
        'company' => 'string',
        'subscriber_id' => 'integer',
        'personal_accountCustomer_id' => 'integer',
        'rate_plan_id' => 'integer',
    ];


}
