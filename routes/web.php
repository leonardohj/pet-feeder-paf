<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GramsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FeederController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\FeedingLog;
use App\Models\Feeder;

Route::get('/landing-page', function (){
    return view('landing-page.landing');
})->name('landing');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');

Route::post('/register' ,[AuthController::class, 'register'])->name('register');
Route::post('/login' ,[AuthController::class, 'login'])->name('login');
Route::post('/logout' ,[AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function (){
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::post('/changeVariables', [GramsController::class, 'store'])->name('changeVariables');
    Route::get('/feeder', [FeederController::class, 'index'])->name('feeder');
    Route::get('/feeder/show/{feeder_id}', [FeederController::class, 'show'])->name('feeder.show');
    Route::post('/feeder', [FeederController::class, 'store'])->name('feeder.create');
    Route::post('/feeder/link', [FeederController::class, 'linkingFeederUser'])->name('feeder.linkUser');
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
        Route::post('/schedule/store/{feeder_id}', [ScheduleController::class, 'store'])
        ->name('schedule.store');
        Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])
        ->name('schedule.update');
});

Route::get('/admin', function(){
    $feeders = Feeder::all();
    return view('admin.index', compact('feeders'));
});

Route::fallback(function () {
    return view('404.404');
});

Route::get('/api/schedules', [ApiController::class, 'getSchedules']);
Route::get('/api/feeder', [ApiController::class, 'getFeeder']);


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