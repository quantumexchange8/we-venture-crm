<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\WithdrawalController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware(['api', 'auth'])->group(function () {
    /**
     * ==============================
     *          Dashboard
     * ==============================
     */
    Route::get('dashboard', [DashboardController::class, 'index']);

    /**
     * ==============================
     *          Withdrawal
     * ==============================
     */
    Route::resource('withdrawal', WithdrawalController::class);
    Route::post('withdrawal_cancel/{id}', [WithdrawalController::class, 'withdrawal_cancel']);
});
