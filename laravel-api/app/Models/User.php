<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_AUTHOR = 'author';

    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'permission'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class);
    }

    public function book()
    {
        return $this->hasMany(Book::class);
    }

    public function status()
    {
        return $this->hasOne(StatusAuthor::class);
    }

    public function getPermissionAttribute()
    {
        return $this->getAllPermissions();
    }
}
