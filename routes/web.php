<?php

use App\Models\Url;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{param_url}', function ($param_url) {
    $short_url = Url::where('param_url', $param_url)->first();

    if ($short_url === null) {
        // Handle the error, e.g., show a 404 page
        abort(404);
    }

    $short_url->increment('visits');

    return redirect($short_url->long_url);
});

 

