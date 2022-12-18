<?php

namespace Usoft\Charges\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeMonthlyStatistic extends Model
{
    protected $connection = 'main';

    protected $table = 'charge_monthly_statistics';

    protected $guarded = ['id'];

    protected $casts = [
        'count' => 'integer',
        'type' => 'string'
    ];
}
