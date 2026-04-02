<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Schedule;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;

class GramsController extends Controller
{
    public function index(Request $request)
    {
        session(['FeederAssociated' => true]);

        $feeder = DB::table('feeder')->where('id_user', '1')->first();
        if(empty($feeder))
        {
            session(['FeederAssociated' => false]);
        }
        
        return view('index');
    }

public function store(Request $request): JsonResponse
{
    $validated = $request->validate([
        'id_feeder' => 'required|integer',
        'time' => 'required|date_format:H:i',
    ]);

    try {
        $schedule = Schedule::create($validated);
        return response()->json($schedule, 201, [], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to create schedule.',
            'message' => $e->getMessage()
        ], 500);
    }
}
}