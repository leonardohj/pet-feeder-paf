<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'feeder_id',
        'name',
        'image',
        'species',
        'gender',
        'weight',
        'birth_date',
        'notes',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'birth_date' => 'date',
    ];

    /**
     * Owner relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Optional feeder relationship
     */
    public function feeder()
    {
        return $this->belongsTo(Feeder::class);
    }
}