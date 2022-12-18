<?php

namespace Usoft\Social\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $connection = 'information_pgsql';

    protected $guarded = ['id'];
}
