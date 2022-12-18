<?php

namespace Usoft\Transactions\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Usoft\Levels\Models\Level;
use Usoft\UserSubscribers\Models\UserSubscriber;

class Transaction extends Model
{
    use SoftDeletes;
    protected $connection = 'transactions_database';

    protected $table = 'transactions';

    protected $casts = [
        'user_id' => 'integer',
        'score' => 'integer',
        'level_id' => 'integer',
        'step' => 'integer',
    ];

    protected $guarded = ['id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\Jenssegers\Mongodb\Relations\BelongsTo
    {
        return $this->belongsTo(UserSubscriber::class, 'user_id', 'id');
    }

    public function level(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\Jenssegers\Mongodb\Relations\BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
