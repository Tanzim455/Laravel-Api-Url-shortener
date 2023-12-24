<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(RegisterRequest $request){
       $user=User::create($request->validated());
       if($user){
        $response=[
            'user'=>$user,
            

        ];

        return response($response,201);
       }

        

        

       
    }

    public function login(LoginRequest $request){
        if(!Auth::attempt($request->only('email', 'password'))){
            return response([
                'errors' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
    
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
    
        return response([
            'jwt' => $token
        ]);
    }

    public function logout(){
        
        auth()->user()->tokens()->delete();
    
        return response([
            'message' => 'Successfully Logged out'
        ]);
    }
    
}
