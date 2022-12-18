<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $connection = 'main';

    protected $casts = [
        'permission' => 'array'
    ];

    public function hasPermission($action, $permission): bool
    {
        return $this->permission[$action][$permission] ?? false;
    }
}
