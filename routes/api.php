<?php

use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Route;

Route::apiResource('recipients', RecipientController::class)->only(['index', 'show']);
