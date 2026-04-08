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
Route::get('/landing-page', function () {
    return view('landing-page.landing');
})->name('landing');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/change-language/{lang}', [AuthController::class, 'changeLang']);

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::post('/changeVariables', [GramsController::class, 'store'])->name('changeVariables');
    Route::get('/feeder', [FeederController::class, 'index'])->name('feeder.index');
    Route::get('/feeder/show/{feeder_id}', [FeederController::class, 'show'])->name('feeder.show');
    Route::post('/feeder', [FeederController::class, 'store'])->name('feeder.create');
    Route::post('/feeder/link', [FeederController::class, 'linkingFeederUser'])->name('feeder.linkUser');
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule/store/{feeder_id}', [ScheduleController::class, 'store'])
        ->name('schedule.store');
    Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])
        ->name('schedule.update');
});

Route::get('/admin', function () {
    $feeders = Feeder::all();
    return view('admin.index', compact('feeders'));
});

Route::fallback(function () {
    return view('404.404');
});

Route::get('/api/schedules', [ApiController::class, 'getSchedules']);
Route::get('/api/feeder', [ApiController::class, 'getFeeder']);