<?php

namespace Usoft\Survey\Models;

use Usoft\AnswersUser\Models\AnswersUser;
use Usoft\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Usoft\Question\Models\Question;

class Survey extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'questionnaire_pgsql';

    protected $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'organization_id' => 'integer',
        'is_draft' => 'boolean',
        'position' => 'integer',
        'dependent_survey_id' => 'integer',
        'is_dependent' => 'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        self:: creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function dependentSurvey()
    {
        return $this->belongsTo(Survey::class, 'dependent_survey_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id', 'id')->with('answers')->with('inputType');
    }

    public function user()
    {
        return $this->belongsTo(AnswersUser::class, 'id','survey_id');
    }


}
