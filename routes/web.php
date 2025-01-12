<?php

use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\MonitoringLogController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\CropReportController;
use App\Http\Controllers\DamageReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherForecastController;
use App\Models\AdditionalInformation;
use App\Models\CropReport;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

//HOME
Route::get('/', function () {
    return view('welcome');
})->name('home');

//TRENDS
Route::get('/trends',  [CropController::class, 'trends'])->name('trends.index');
Route::get('trends/price/{cropName}/{variety?}', [CropReportController::class, 'price'])->name('trends.price');
Route::get('trends/stats/{cropName}/{variety?}', [CropReportController::class, 'stats'])->name('trends.stats');
Route::get('trends/info/{crop_id}', [AdditionalInformationController::class, 'showInformation'])->name('trends.info');

//WEATHER FORECAST
Route::get('/weather_forecasts', [WeatherForecastController::class, 'index'])->name('weather_forecasts.index');

//DAMAGES
Route::get('damages/pests', [DamageReportController::class, 'pests'])->name('damages.pests');
Route::get('damages/diseases', [DamageReportController::class, 'diseases'])->name('damages.diseases');
Route::get('damages/natural-disaster', [DamageReportController::class, 'disasters'])->name('damages.disasters');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, "user"])->name('dashboard');

    //Crops
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

    //Crop Reports
    Route::get('/manage-crop-report', [CropReportController::class, 'index'])->name('crop_reports.index');
    Route::get('/manage-crop-report/create', [CropReportController::class, 'create'])->name('crop_reports.create');
    Route::post('/manage-crop-report/store', [CropReportController::class, 'store'])->name('crop_reports.store');
    Route::get('/manage-crop-report/{cropReport}/edit', [CropReportController::class, 'edit'])->name('crop_reports.edit');
    Route::put('/manage-crop-report/{cropReport}', [CropReportController::class, 'update'])->name('crop_reports.update');
    Route::delete('/manage-crop-report/{cropReport}', [CropReportController::class, 'destroy'])->name('crop_reports.destroy');

    //Damage Reports
    Route::get('/manage-damage-report', [DamageReportController::class, 'index'])->name('damage_reports.index');
    Route::get('/manage-damage-report/create', [DamageReportController::class, 'create'])->name('damage_reports.create');
    Route::post('/manage-damage-report/store', [DamageReportController::class, 'store'])->name('damage_reports.store');
    Route::get('/manage-damage-report/{damageReport}/edit', [DamageReportController::class, 'edit'])->name('damage_reports.edit');
    Route::put('/manage-damage-report/{damageReport}', [DamageReportController::class, 'update'])->name('damage_reports.update');
    Route::delete('/manage-damage-report/{damageReport}', [DamageReportController::class, 'destroy'])->name('damage_reports.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    //Users
    Route::get('/admin/manage-users', [RegisteredUserController::class, 'index'])
        ->name('admin.manage-users');
    Route::get('/admin/add-user', [RegisteredUserController::class, 'create'])->name('admin.add-user');
    Route::post('/admin/register', [RegisteredUserController::class, 'store'])->name('admin.register');;
    Route::post('/admin/toggle-status/{id}', [RegisteredUserController::class, 'toggleStatus'])->name('admin.toggle-status');

    //Crops
    Route::get('/view-crop', [CropController::class, 'indexAdmin'])->name('admin.crops.index');
    Route::get('/view-crop/upload/{crop}', [AdditionalInformationController::class, 'indexAdmin'])->name('admin.upload.index');

    //Crop Reports
    Route::get('/view-crop-reports', [CropReportController::class, 'indexAdmin'])->name('admin.crop_reports.index');

    //Damages Reports
    Route::get('/view-damage-report', [DamageReportController::class, 'indexAdmin'])->name('admin.damage_reports.index');

    //Logs
    Route::get('/admin/logs', [MonitoringLogController::class, 'index'])->name('admin.logs.index');
});

Route::get('/phpinfo', function () {
    phpinfo();
});


require __DIR__ . '/auth.php';
