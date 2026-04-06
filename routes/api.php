<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GramsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FeederController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Models\Feeder;
use App\Models\FeedingLog;
use Illuminate\Http\Request;

Route::post('api/feeding-log', function(Request $request) {

    // Authenticate feeder (replace with your actual auth logic)
    $feeder = $request->bearerToken() ? Feeder::where('token', $request->bearerToken())->first() : null;

    if (!$feeder) {
        return response()->json(['error' => 'Invalid or missing token'], 401);
    }

    // Validate request
    $validated = $request->validate([
        'date'     => 'required|string',
        'hour'     => 'required|string',
        'quantity' => 'required|integer',
        'status'   => 'required|string',
        'notes'    => 'nullable|string'
    ]);

    // Attach feeder ID
    $validated['feeder_id'] = $feeder->id;

    // Create feeding log
    $feedingLog = FeedingLog::create($validated);

    return response()->json($feedingLog, 201);
});