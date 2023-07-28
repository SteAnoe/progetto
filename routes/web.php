<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SponsorshipController;





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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::resource('/dashboard', DoctorController::class);

// });

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/sponsorship', [SponsorshipController::class, 'token'])->name('token');
    //Route::post('/sponsorship', [SponsorshipController::class, 'tokenStore'])->name('tokenStore');
    Route::resource('/dashboard', DoctorController::class)->parameters(
        [
            'user' => 'user:slug'
        ]);
    
});

require __DIR__.'/auth.php';