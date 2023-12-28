<?php

namespace App\Http\Controllers;

use App\Models\UrlVisit;
use Illuminate\Http\Request;

class UrlVisitController extends Controller
{
    //
    public function index(){
        $url_visits=UrlVisit::select('short_url','visits')->where('user_id',auth()?->user()?->id)->get();

        return response()->json(
            [
                'url_visits'=>$url_visits
            ]
            
        );
    }
}
