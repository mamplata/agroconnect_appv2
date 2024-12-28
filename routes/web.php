<?php

use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\MonitoringLogController;
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
    Route::get('/manage-crop', [CropController::class, 'index'])->name('crops.index');
    Route::get('/manage-crop/create', [CropController::class, 'create'])->name('crops.create');
    Route::post('/manage-crop/store', [CropController::class, 'store'])->name('crops.store');
    Route::get('/manage-crop/{crop}/edit', [CropController::class, 'edit'])->name('crops.edit');
    Route::put('/manage-crop/{crop}', [CropController::class, 'update'])->name('crops.update');
    Route::delete('/manage-crop/{crop}', [CropController::class, 'destroy'])->name('crops.destroy');
    Route::get('/manage-crop/upload/{crop}', [AdditionalInformationController::class, 'index'])->name('upload.index');
    Route::get('/manage-crop/upload/create/{crop_id}', [AdditionalInformationController::class, 'create'])->name('upload.create');
    Route::post('/manage-crop/upload/store', [AdditionalInformationController::class, 'store'])->name('upload.store');
    Route::delete('manage-crop/upload/{crop_id}/destroy/{additionalInformation}', [AdditionalInformationController::class, 'destroy'])->name('upload.destroy');
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
    Route::get('/view-crop', [CropController::class, 'indexAdmin'])->name('admin.crops.index');
    Route::get('/view-crop/upload/{crop}', [AdditionalInformationController::class, 'indexAdmin'])->name('admin.upload.index');
    Route::get('/admin/logs', [MonitoringLogController::class, 'index'])->name('admin.logs.index');
});

Route::get('/phpinfo', function () {
    phpinfo();
});


require __DIR__ . '/auth.php';
