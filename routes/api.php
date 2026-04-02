<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GramsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FeederController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Models\Feeder;

Route::get('/schedules', [ApiController::class, 'getSchedules']);
Route::get('/feeder', [ApiController::class, 'getFeeder']);
Route::post('/feeding-log', [ApiController::class, 'store']);