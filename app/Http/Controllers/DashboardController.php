<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feeder;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get all feeders of this user with their feeding logs
        $feeders = Feeder::with('feedingLogs')
            ->where('id_user', $userId)
            ->get();

        // Optionally, flatten all logs into one collection
        $feedingLogs = $feeders->pluck('feedingLogs')->flatten();

        return view('dashboard.index', compact('feeders', 'feedingLogs'));
    }
}