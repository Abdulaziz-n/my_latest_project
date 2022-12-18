<?php

namespace Usoft\InputType\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InputType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'questionnaire_pgsql';

    protected $casts = [
        'name' => 'string',
        'type' => 'string'
    ];
}
