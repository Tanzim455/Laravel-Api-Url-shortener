<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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

Route::get('/', function () {
    $url = config('app.url');
    $str = Str::random(5);
    $hello = $url . '/' . $str;
    dd($hello);
});
 Route::get('/dvZ5X',function(){
 $url="https://learning.postman.com/docs/getting-started/first-steps/sending-the-first-request/";
 
 return redirect($url);
 });

