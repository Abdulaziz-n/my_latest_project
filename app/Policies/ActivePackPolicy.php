<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivePackPolicy
{
    use HandlesAuthorization;

    const ACTIVATE = 'activate';

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
    public function activate(User $user): bool
    {
        return $user->hasPermission('activate_pack', self::ACTIVATE);
    }

}
