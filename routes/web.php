<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/manage-crop', [CropController::class, 'index'])->name('manage-crop');
    Route::get('/manage-crop/create', [CropController::class, 'create'])->name('crops.create');
    Route::post('/manage-crop/store', [CropController::class, 'store'])->name('crops.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/manage-users', [RegisteredUserController::class, 'index'])
        ->name('admin.manage-users');
    Route::get('/admin/add-user', [RegisteredUserController::class, 'create'])->name('admin.add-user');
    Route::post('/admin/register', [RegisteredUserController::class, 'store'])->name('admin.register');;
    Route::post('/admin/toggle-status/{id}', [RegisteredUserController::class, 'toggleStatus'])->name('admin.toggle-status');
});

Route::get('/phpinfo', function () {
    phpinfo();
});


require __DIR__ . '/auth.php';
