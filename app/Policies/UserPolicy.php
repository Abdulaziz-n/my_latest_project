<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
//use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    const VIEW = 'view';
    const UPDATE = 'update';
    const CREATE = 'create';
    const DELETE = 'delete';

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->hasPermission('users', self::VIEW);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('users', self::UPDATE);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasPermission('users', self::DELETE);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('users', self::CREATE);
    }

}
