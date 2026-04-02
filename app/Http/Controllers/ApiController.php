<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Feeder;
use App\Models\FeedingLog;

class ApiController extends Controller
{
    /**
     * Authenticate device using Bearer token
     */
    private function authenticate(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return null;
        }

        return Feeder::where('device_token', $token)->first();
    }

    /**
     * Get schedules for authenticated feeder
     */
    public function getSchedules(Request $request)
    {
        $feeder = $this->authenticate($request);

        if (!$feeder) {
            return response()->json([
                'error' => 'Invalid or missing device token'
            ], 401);
        }

        $schedules = Schedule::where('id_feeder', $feeder->id)->get();

        return response()->json($schedules);
    }

    /**
     * Get feeder info
     */
    public function getFeeder(Request $request)
    {
        $feeder = $this->authenticate($request);

        if (!$feeder) {
            return response()->json([
                'error' => 'Invalid or missing device token'
            ], 401);
        }

        return response()->json($feeder);
    }

    /**
     * Store feeding log from device
     */
    public function store(Request $request)
    {
        $feeder = $this->authenticate($request);

        if (!$feeder) {
            return response()->json([
                'error' => 'Invalid or missing device token'
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