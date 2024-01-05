<?php

namespace App\Http\Controllers;

use App\Http\Resources\UrlCollection;
use App\Http\Resources\UrlResource;
use App\Http\Resources\UserResource;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
          $url=Url::where('user_id',auth()?->user()?->id)->select('long_url')->paginate(10);
          return new UrlCollection($url);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data as needed
        $validated = $request->validate([
        'long_url' => 'url|required',
    ]);

    // Check if the URL already exists for the authenticated user
    $urlExists = Url::where('long_url', $request->input('long_url'))
        ->where('user_id', auth()->user()->id)
        ->first();

    if ($urlExists) {
        // If the URL exists for the user, return the existing short URL
        return response()->json([
            'short_url' => $urlExists->short_url
        ]);
    }

    // If the URL does not exist, create a new URL entry
    $url = Url::create($validated);

    // Return the newly created short URL
    return response()->json([
        'short_url' => $url->short_url
    ]);
    }

    
}
