<?php
use App\Http\Controllers\SensorDataController;
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
Route::post('/data', [SensorDataController::class, 'store']);
Route::get('/data', [SensorDataController::class, 'store']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
