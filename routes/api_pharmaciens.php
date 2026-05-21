<?php

use App\Http\Controllers\PharmacienController;
use Illuminate\Support\Facades\Route;


Route::apiResource('pharmaciens', PharmacienController::class);