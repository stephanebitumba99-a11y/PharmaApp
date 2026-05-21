<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenteController;


Route::post('/ventes', [VenteController::class, 'store']);
Route::get('/ventes', [VenteController::class, 'index']);