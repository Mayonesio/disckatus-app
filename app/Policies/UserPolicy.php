<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function edit(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id || $currentUser->isCaptain();
    }

    public function manageTeam(User $user)
    {
        return $user->isCaptain();
    }
}