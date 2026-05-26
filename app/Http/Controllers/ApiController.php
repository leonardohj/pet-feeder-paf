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
        $token = $request->bearerToken();
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
        $feederId = $request->query('feeder_id');

        if ($feederId) {
            $feeder = Feeder::find($feederId);

            if (!$feeder) {
                return response()->json([
                    'error' => 'Feeder not found'
                ], 404);
            }
        } else {
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
     */public function store(Request $request)
{
    $token = $request->bearerToken();

    $feeder = Feeder::where('device_token', $token)->first();

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

    $feedingLog = FeedingLog::create([
        'id_feeder' => $feeder->id,
        'date' => $validated['date'],
        'hour' => $validated['hour'],
        'quantity' => $validated['quantity'],
        'status' => $validated['status'],
    ]);

    $feeder->update([
        'last_fed_at' => $validated['date'] . ' ' . $validated['hour'],
        'status' => true,
    ]);

    return response()->json($feedingLog, 201);
}
}