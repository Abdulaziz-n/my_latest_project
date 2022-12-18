<?php

namespace Usoft\AnswersUser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswersUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'questionnaire_pgsql';

    protected $guarded = ['id'];
}
