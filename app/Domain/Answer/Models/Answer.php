<?php

namespace Usoft\Answer\Models;

use Usoft\Question\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Answer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'questionnaire_pgsql';

    protected $table = 'answers';

    protected $casts = [
        'uuid' => 'string',
        'name' => 'array',
        'hint' => 'array',
        'question_id' => 'integer',
        'position' => 'integer'
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

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_answers', 'user_id', 'answer_id');
    }
}
