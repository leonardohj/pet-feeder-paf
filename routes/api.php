<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Feeder;
use App\Models\FeedingLog;


Route::post('/create-feeding-log', function (Request $request) {

    $feeder = Feeder::find($request->input('feeder_id'));
    if (!$feeder) {
        return response()->json(['error' => 'Invalid or missing token'], 401);
    }

    // Validate input
    $validated = $request->validate([
        'date'     => 'required|date',
        'hour'     => 'required|string',
        'quantity' => 'required|integer',
        'status'   => 'required|string',
        'notes'    => 'nullable|string'
    ]);

    // Attach feeder ID
    $validated['feeder_id'] = $feeder->id;

    // Create feeding log
    $feedingLog = FeedingLog::create($validated);

    return response()->json([
        'message' => 'Feeding log created successfully',
        'feeding_log' => $feedingLog
    ], 201);

});