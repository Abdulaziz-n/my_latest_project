<?php

namespace Usoft\Statistics\Models;

use Illuminate\Database\Eloquent\Model;
use Usoft\Gifts\Models\Gift;

class GiftHistoryStatistic extends Model
{
    protected $table = 'gifts_histories_statistics';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'count' => 'integer',
        'gift_id' => 'integer'
    ];


    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

}
