<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles
{
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('slug', (array) $roles)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function isCaptain()
    {
        return $this->hasRole('captain');
    }

    public function isSotgCaptain()
    {
        return $this->hasRole('sotg-captain');
    }

    public function getRoleNames()
    {
        return $this->roles->pluck('name')->implode(', ');
    }

    public function getHighestRole()
    {
        $roleHierarchy = [
            'super-admin' => 4,
            'captain' => 3,
            'sotg-captain' => 2,
            'player' => 1
        ];

        return $this->roles()
            ->orderByRaw("FIELD(slug, 'super-admin', 'captain', 'sotg-captain', 'player') DESC")
            ->first();
    }
}