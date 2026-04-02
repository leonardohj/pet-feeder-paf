<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    public $timestamps = true;

    protected $fillable = [
        'feeder_id',
        'time',
        'quantity',
        'type',
        'days'
    ];

    protected $casts = [
        'days' => 'array',
    ];

    public function feeder()
    {
        return $this->belongsTo(Feeder::class, 'feeder_id');
    }
}