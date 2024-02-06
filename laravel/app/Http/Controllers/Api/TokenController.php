<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class TokenController extends Controller
{
    public function user(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();
       
        return response()->json([
            "success" => true,
            "user"    => $request->user(),
            "roles"   => [$user->role->name],
        ]);
    }
 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Get user
            $user = User::where([
                ["email", "=", $credentials["email"]]
            ])->firstOrFail();
            // Revoke all old tokens
            $user->tokens()->delete();
            // Generate new token
            $token = $user->createToken("authToken")->plainTextToken;
            // Token response
            return response()->json([
                "success"   => true,
                "authToken" => $token,
                "tokenType" => "Bearer"
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }
    }

    public function logout(Request $request)
    {
       if (null != $request->user()->tokens()) {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
       }else{
        return response()->json([
            'success' => false,
            'message' => 'User logged out unauthorized'
        ]);
       } 
        
    }

    public function register(Request $request)
    {
       $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required',  Rules\Password::defaults()],
        ]);
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 1
        ]);
    
        $token = $user->createToken('authToken')->plainTextToken;
    
        return response()->json([
            'success'   => true,
            'authToken' => $token,
            'tokenType' => 'Bearer',
            'message'   => 'User registered successfully'
        ], 200);
    }
   
}
