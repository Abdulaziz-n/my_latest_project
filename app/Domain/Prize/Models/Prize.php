<?php

namespace Usoft\Prize\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prize extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $connection = 'information_pgsql';
    protected $guarded = ['id'];

}
