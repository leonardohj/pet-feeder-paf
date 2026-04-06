<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Feeder;
use App\Models\FeedingLog;

class ApiController extends Controller
{
    /**
     * Authenticate device using Bearer token OR query token
     */
    private function authenticate(Request $request)
    {
        // Try Authorization Bearer token first
        $token = $request->bearerToken();

        // If not present, allow ?token=xxx
        if (!$token) {
            $token = $request->query('token');
        }

        if (!$token) {
            return null;
        }

        return Feeder::where('device_token', $token)->first();
    }

    /**
     * Get schedules
     */
    public function getSchedules(Request $request)
{
    // If a feeder_id is passed via query, use it
    $feederId = $request->query('feeder_id');

    if ($feederId) {
        $feeder = Feeder::find($feederId);

        if (!$feeder) {
            return response()->json([
                'error' => 'Feeder not found'
            ], 404);
        }
    } else {
        // Fallback: authenticate via token
        $feeder = $this->authenticate($request);

        if (!$feeder) {
            return response()->json([
                'error' => 'Invalid or missing token'
            ], 401);
        }
    }

    return Schedule::where('feeder_id', $feeder->id)->get();
}

    /**
     * Get feeder info
     */
    public function getFeeder(Request $request)
    {
        $feeder = $this->authenticate($request);

        if (!$feeder) {
            return response()->json([
                'error' => 'Invalid or missing token'
            ], 401);
        }

        return response()->json($feeder);
    }

    /**
     * Store feeding log
     */
    public function store(Request $request)
    {
        return response()->json(['ola' => 'adeus']);


        if (!$feeder) {
            return response()->json([
                'error' => 'Invalid or missing token'
            ], 401);
        }

        $validated = $request->validate([
            'date' => 'required|string',
            'hour' => 'required|string',
            'quantity' => 'required|integer',
            'status' => 'required|string'
        ]);

        $validated['id_feeder'] = $feeder->id;

        $feedingLog = FeedingLog::create($validated);

        return response()->json($feedingLog, 201);
    }
}