<?php

namespace Usoft\Charges\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ChargePremium extends Model
{
    protected $connection = 'charges_premium_database';

    protected $collection = 'charge_premium';

    protected $guarded = ['id'];

    protected $casts = [
        'attempt' => 'integer',
        'charged_at' => 'date',
        'date' => 'date',
        'last_attempt' => 'date',
        'status' => 'integer',
        'tariff' => 'integer',
        'user_id' => 'integer',
        'stop' => 'boolean',
        'subscribe' => 'boolean',
        'phone' => 'integer',
        'price' => 'double',
        'uuid' => 'string',
    ];
}
