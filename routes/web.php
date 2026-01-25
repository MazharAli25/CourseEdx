<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SliderImageController;
use App\Http\Controllers\SystemSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::prefix('super-admin')->group(function(){
    Route::view('dashboard', 'SuperAdmin.dashboard')->name('super.dashboard');
    Route::get('system-settings', [SystemSettingController::class, 'homeCustomization'])->name('super.homeCustomization');
    Route::post('system-settings', [SystemSettingController::class, 'homeCustomizationUpdate'])->name('super.homeCustomizationUpdate');
    Route::resource('slider-images', SliderImageController::class);
}); 