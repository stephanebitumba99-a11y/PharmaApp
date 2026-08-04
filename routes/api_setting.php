<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;


Route::get('/settings', [SettingController::class, 'index']);
Route::put('/settings', [SettingController::class, 'update']);
