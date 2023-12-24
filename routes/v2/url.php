<?php

use App\Http\Controllers\UrlVisitController;
use Illuminate\Support\Facades\Route;

  Route::get('v2/shorturls',[UrlVisitController::class,'index']);