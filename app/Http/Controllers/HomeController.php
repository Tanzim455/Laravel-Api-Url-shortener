<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index($param_url){
        $short_url =Url::where('param_url', $param_url)->first();

    if ($short_url === null) {
        // Handle the error, e.g., show a 404 page
        abort(404);
    }

    // $short_url->increment('visits');

    return redirect($short_url->long_url);
    }
}
