<?php

namespace App\Models;

use App\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Services\FirebaseStorageService;

class User extends Authenticatable
{
    use HasFactory,  Notifiable, HasRoles;

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

    protected $appends = ['avatar_url', 'initials'];

    public function playerProfile()
    {
        return $this->hasOne(PlayerProfile::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }

        // Si es una URL de Firebase o Google, devolverla directamente
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        // Si es una ruta local (legacy), usar Storage
        return asset('storage/' . $this->avatar);
    }

    public function getInitialsAttribute()
    {
        return ucfirst(substr($this->name, 0, 1));
    }

    public function updateAvatar($file)
    {
        $firebaseStorage = app(FirebaseStorageService::class);

        // Si hay un avatar anterior en Firebase, eliminarlo
        if ($this->avatar && filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            $firebaseStorage->deleteAvatar($this->avatar);
        }

        // Subir nuevo avatar
        $avatarUrl = $firebaseStorage->uploadAvatar($file, $this->id);
        $this->avatar = $avatarUrl;
        $this->save();

        return $avatarUrl;
    }

    public function removeAvatar()
    {
        if ($this->avatar) {
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                app(FirebaseStorageService::class)->deleteAvatar($this->avatar);
            }
            $this->avatar = null;
            $this->save();
        }
    }

    public function canUpdateProfile($targetUser)
    {
        return $this->id === $targetUser->id || $this->hasRole('captain');
    }
}