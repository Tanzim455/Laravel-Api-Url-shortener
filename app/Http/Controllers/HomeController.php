<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlVisit;

class HomeController extends Controller
{
    public function index($param_url)
    {
        $short_url = Url::where('param_url', $param_url)->select('short_url', 'long_url', 'user_id')->first();

        if ($short_url === null) {
            // Handle the error, e.g., show a 404 page
            abort(404);
        }

        $short_url_exists = UrlVisit::where('short_url', $short_url->short_url)
            ->where('user_id', $short_url->user_id)
            ->first();

        if (! $short_url_exists) {
            $visit = 1;
            UrlVisit::create([
                'short_url' => $short_url->short_url,
                'visits' => $visit,
                'user_id' => $short_url->user_id,
            ]);

            return redirect($short_url->long_url);
        }

        if ($short_url_exists) {
            $short_url_exists->increment('visits');

            return redirect($short_url->long_url);
        }
    }
}
