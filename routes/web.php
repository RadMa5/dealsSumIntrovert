<?php

use App\Http\Controllers\DealsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DealsController::class, 'index']);
