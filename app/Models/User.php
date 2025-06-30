<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['role_name', 'role_colors'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role_name
     *
     * @param  string  $value
     * @return string
     */
    public function getRoleNameAttribute()
    {
        return Str::title($this->role);
    }

    /**
     * Get the role_colors
     *
     * @param  string  $value
     * @return string
     */
    public function getRoleColorsAttribute($value)
    {
        return $this->role == 'admin'
                ? ['#ffffff', '#007bff'] // [text color (white), background color (blue)] for admin
                : ['#333333', '#f0ad4e']; // [text color (dark), background color (orange)] for non-admin
    }
}
