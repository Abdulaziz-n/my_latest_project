<?php

namespace Usoft\Question\Models;

use Usoft\Answer\Models\Answer;
use Usoft\InputType\Models\InputType;
use Usoft\Survey\Models\Survey;

//use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Question extends Model
{
//    use Uuids;
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'questionnaire_pgsql';

    protected $guarded = ['id'];

    protected $table = 'questions';
    protected $casts = [
        'uuid' => 'string',
        'name' => 'array',
        'hint' => 'array',
        'survey_id' => 'integer',
        'award_coins' => 'integer',
        'position' => 'integer',
        'input_type_id' => 'integer',
        'is_draft' => 'boolean',
        'is_multiple' => 'boolean',
        'is_required' => 'boolean',
        'timer' => 'integer'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getNameAttribute()
    {
        if (request()->header('Accept-Language')){
            $locale = request()->header('Accept-Language');
            $lang = json_decode($this->attributes['name']);
            return $lang->$locale;
        }
        return json_decode($this->attributes['name']);
    }

    public function getHintAttribute()
    {
        if (request()->header('Accept-Language')){
            $locale = request()->header('Accept-Language');
            $lang = json_decode($this->attributes['hint']);
            return $lang->$locale;
        }
        return json_decode($this->attributes['hint']);
    }

    protected static function boot()
    {
        parent::boot();
        self:: creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function inputType()
    {
        return $this->belongsTo(InputType::class, 'input_type_id', 'id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }


}
