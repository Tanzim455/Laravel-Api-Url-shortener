<?php

namespace App\Http\Controllers;

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
        //
        $url=Url::select('long_url')->where('user_id',auth()?->user()?->id)->get();
         //or 
        //  $url=Auth::user()->urls()->select('short_url')->get();
        return response()->json(
            [
                'url'=>$url
            ]
            
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }
    

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
