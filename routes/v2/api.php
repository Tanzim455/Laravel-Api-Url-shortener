<?php

use App\Http\Controllers\UrlVisitController;
use Illuminate\Support\Facades\Route;

Route::get('shorturls', [UrlVisitController::class, 'index'])->middleware('auth:sanctum');
