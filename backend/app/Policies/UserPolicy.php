<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;

class UserPolicy
{
    public function admin(User $user): bool
    {
        return $user->roles()->where('user_roles.id', UserRole::ADMIN)->exists();
    }

    public function master(User $user): bool
    {
        return $user->roles()->where('user_roles.id', [ UserRole::MASTER, UserRole::ADMIN ])->exists();
    }
}
