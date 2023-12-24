<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::post('v1/register',[AuthController::class,'register']);

Route::post('v1/login',[AuthController::class,'login']);

Route::apiResource('v1/url',UrlController::class)->middleware('auth:sanctum');