<?php

use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;


Route::apiResource('produits', ProduitController::class);