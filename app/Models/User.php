<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'avatar_color',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['avatar_url'];

    public function playerProfile()
    {
        return $this->hasOne(PlayerProfile::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    // Métodos de roles
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            return $this->roles()->whereIn('slug', $roles)->exists();
        }
        return $this->hasRole($roles);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('slug', $role)->exists();
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function isCaptain()
    {
        return $this->hasRole('captain');
    }

    // Métodos de avatar
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar; // Avatar de Google
            }
            return Storage::url($this->avatar); // Avatar subido
        }
        return null;
    }

    public function getInitialsAttribute()
    {
        return substr($this->name, 0, 1);
    }

    public function getAvatarDisplayAttribute()
    {
        if ($this->avatar) {
            return $this->avatar_url;
        }
        
        if ($this->avatar_color) {
            return [
                'type' => 'color',
                'color' => $this->avatar_color,
                'initials' => $this->initials
            ];
        }

        return [
            'type' => 'default',
            'color' => '#10163f',
            'initials' => $this->initials
        ];
    }

    public function clearAvatar()
    {
        if ($this->avatar && !filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($this->avatar);
        }
        $this->avatar = null;
        $this->avatar_color = null;
        $this->save();
    }

    public function updateAvatar($path = null, $color = null)
    {
        $this->clearAvatar();
        
        if ($path) {
            $this->avatar = $path;
        } elseif ($color) {
            $this->avatar_color = $color;
        }
        
        return $this->save();
    }
}