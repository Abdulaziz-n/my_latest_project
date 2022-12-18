<?php

namespace Usoft\Categories\Models;
use Illuminate\Database\Eloquent\Model;
use Usoft\Gifts\Models\Gift;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $connection = 'gifts_pgsql';

    public function gifts()
    {
        return $this->belongsToMany(Gift::class, 'gifts_categories', 'category_id', 'gift_id');
    }
}
