<?php

namespace Usoft\TGSubscriber\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramSubscriber extends Model
{
    protected $connection = 'tg_users_pgsql';

    protected $table = 'users';


}
