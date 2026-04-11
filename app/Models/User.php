<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id'
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

    // ----------------------------
    // Relationship with custom foreign key
    // ----------------------------
    public function feeders()
    {
        return $this->hasMany(Feeder::class, 'id_user');
    }

    // ----------------------------
    // Check if user has feeders
    // ----------------------------
    public function hasFeeders(): bool
    {
        return $this->feeders()->exists();
    }

    public function hasLogs(): bool
    {
        // Check if any of the user's feeders have logs
        return $this->feeders()->with('feedingLogs')->get()->contains(function ($feeder) {
            return $feeder->hasLogs();
        });
    }
}