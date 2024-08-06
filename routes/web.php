<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorDataController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [DashboardController::class, 'index']);
Route::post('/store', [DashboardController::class, 'store']);
Route::get('/add-data', [DashboardController::class, 'create']);
Route::post('/add-data', [DashboardController::class, 'store']);
Route::get('/dashboard', [SensorDataController::class, 'index']);