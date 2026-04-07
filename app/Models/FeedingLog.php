<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedingLog extends Model
{
    protected $table = 'feeding_logs';

    public $timestamps = false;

    protected $fillable = [
        'feeder_id',
        'quantity',
        'status',
        'notes',
        'date',
        'hour'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function feeder()
    {
        return $this->belongsTo(Feeder::class, 'feeder_id');
    }
}