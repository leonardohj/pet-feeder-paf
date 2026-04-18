<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeder extends Model
{
    protected $table = 'feeders';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'name',
        'status',
        'code',
        'pet_type',
        'last_fed_at',
        'device_token',
    ];

    protected $casts = [
        'last_fed_at' => 'datetime:Y-m-d H:i',
        'status' => 'boolean',
    ];

    // Relationships

    public function feedingLogs()
    {
        return $this->hasMany(FeedingLog::class, 'feeder_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'feeder_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function hasLogs(): bool
    {
        return $this->feedingLogs()->exists();
    }
}