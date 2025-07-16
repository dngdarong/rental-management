<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image_path', // Add profile_image_path to fillable
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
        'password' => 'hashed',
        'role' => 'string',
    ];

    /**
     * Get the URL for the user's profile image.
     *
     * @return string
     */
    public function getProfileImageUrlAttribute(): string
    {
        // Check if a profile image path exists and if the file exists in storage
        if ($this->profile_image_path && Storage::disk('public')->exists($this->profile_image_path)) {
            // Manually build the URL if the 'url' method is not available
            return asset('storage/' . $this->profile_image_path);
        }

        // Return a Gravatar URL or a default placeholder if no image exists
        // Gravatar is a good fallback for user avatars
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=200&d=mp"; // 'mp' for mystery person
    }


    /**
     * Check if the user is a Super Admin.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if the user is an Admin Tenant.
     *
     * @return bool
     */
    public function isAdminTenant(): bool
    {
        return $this->role === 'admin_tenant';
    }
}

