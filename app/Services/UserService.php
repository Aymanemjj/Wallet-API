<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\HTTP\Request;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function register($request)
    {
        $validated = $request->validated();

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        $results['token'] = $user->createToken('wallet_api')->plainTextToken;

        return [$results, $user];
    }

    public function login($request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong credentials'
            ], 401);
        }

        $user = Auth::user();
        /* check later */
        $token = $user->createToken('wallet_api')->plainTextToken; 

        return ["token"=>$token, 'user'=>$user];

    }



    public function logout(Request $request)
    {
         Auth::user()->currentAccessToken()->delete();
        
    }
}
