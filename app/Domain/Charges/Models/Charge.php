<?php

namespace Usoft\Charges\Models;

//use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
//    protected $connection = 'charges_database';
//    protected $collection = 'charge_daily';
//
//    protected $guarded = ['id'];
//
//     protected $casts = [
//       'attempt' => 'integer',
//       'charged_at' => 'date',
//       'date' => 'date',
//       'last_attempt' => 'date',
//       'status' => 'integer',
//       'tariff' => 'integer',
//       'user_id' => 'integer',
//       'stop' => 'boolean',
//       'subscribe' => 'boolean',
//       'phone' => 'integer',
//       'price' => 'double',
//       'uuid' => 'string',
//     ];

    protected $connection = 'daily_charges_psql';

    public $guarded = ['id'];

    protected $table = 'charges';

    public $timestamps = false;

    protected $casts = [
//        'date' => 'date:Y-m-d',
        'user_id' => 'integer',
        'uuid' => 'string',
        'tariff' => 'integer',
        'status' => "integer",
        'date' => 'date',
        'last_attempt' => 'date',
        'attempt' => 'integer',
        'charged_at' => 'date',
        'stop' => 'boolean'
    ];

}


