<?php

namespace Usoft\Charges\Models;

use Illuminate\Database\Eloquent\Model;


class ChargeStatistic extends Model
{
    protected $connection = 'main';

    protected $table = 'charge_statistics';

    protected $guarded = ['id'];

    protected $casts = [
        'type' => 'string',
        'tariff' => 'integer',
        'count' => 'integer',
        'user_phone' => 'string'
//         'date' => "date:Y-m-d\T:Z",
    ];


}
