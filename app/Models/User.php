<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'is_admin',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
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
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Create API token for user
     */
    public function createApiToken()
    {
        // Generate a random token
        $token = Str::random(60);
        
        // Store token in database (you might want to create a personal_access_tokens table)
        // For now, we'll use a simple approach with user's remember_token or create a tokens table
        $this->api_token = hash('sha256', $token);
        $this->save();
        
        return $token;
    }

    /**
     * Revoke API token
     */
    public function revokeApiToken()
    {
        $this->api_token = null;
        $this->save();
    }
}
