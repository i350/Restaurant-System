<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ALLOWED_ROLES = ['customer', 'merchant']; // Simple roles, no need for table

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isMerchant(): bool
    {
        return $this->getAttribute('role') === 'merchant';
    }
    public function isCustomer(): bool
    {
        return $this->getAttribute('role') === 'customer';
    }
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // ----------------------------------- Relationships
    public function orders(): HasMany
    {
        return $this->HasMany(Order::class);
    }
}
