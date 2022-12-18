<?php

namespace Usoft\Gifts\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftsCategory extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'gifts_pgsql';
}
