<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__.'/api_pharmaciens.php';
require __DIR__.'/api_users.php';
require __DIR__.'/api_auth.php';
require __DIR__.'/api_produits.php';
require __DIR__.'/api_ventes.php';


Route::get('/dashbord', [DashboardController::class, 'stats']);