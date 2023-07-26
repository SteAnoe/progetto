<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\SpecializationController;
use App\Http\Controllers\Api\MessageController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/doctors',[DoctorController::class,'index','filterByStar']);
Route::get('/doctors/{slug}', [DoctorController::class, 'show']);
Route::get('/specializations', [SpecializationController::class, 'index']);
Route::get('/specializations/{slug}', [SpecializationController::class, 'show']);
Route::post('/doctors/{slug}/message', [MessageController::class, 'store']);