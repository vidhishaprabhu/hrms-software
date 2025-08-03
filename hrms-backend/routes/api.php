<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/total-employees', [EmployeeController::class, 'totalEmployees']);
Route::get('/new-joinees', [EmployeeController::class, 'getNewJoineesThisMonth']);
Route::get('/total-leaves', [LeaveController::class, 'totalLeavesByEmployee']);
Route::get('/approved-leaves', [LeaveController::class, 'approvedLeavedCount']);
Route::get('/rejected-leaves', [LeaveController::class, 'rejectedLeavedCount']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    
});
