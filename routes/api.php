<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --- Register ---
// Route::post('register', [AuthController::class, 'register']);

Route::middleware('api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('jwt.auth')->group(function () {
    Route::post('/insertData', [DataController::class, 'insertData'])->name('api.insertData');
});
