<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * USER ATTRIBUTES
     * $this->attributes['id'] - int - contains the user primary key
     * $this->attributes['name'] - string - contains the user name
     * $this->attributes['last_name'] - string - contains the user last name
     * $this->attributes['email'] - string - contains the user email
     * $this->attributes['password'] - string - contains the user password
     * $this->attributes['address'] - string - contains the user address
     * $this->attributes['role'] - string - contains the user role
     * $this->attributes['created_at'] - datetime - contains the creation date
     * $this->attributes['updated_at'] - datetime - contains the update date
     * $this->orders - Order[] - contains the user orders list
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function validate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:255',
            'role' => 'required|string|in:client,admin',
        ]);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function getFullName(): string
    {
        return $this->name.' '.$this->last_name;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isGuest(): bool
    {
        return $this->role === null;
    }

    // Getters for related models

    public function getOrders(): EloquentCollection
    {
        return $this->orders;
    }
}
