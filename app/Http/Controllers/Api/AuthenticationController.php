<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\StoreUser;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    private UserService $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }


    public function register(StoreUser $request)
    {
        try {

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully.',
                'data' => $this->UserService->register($request)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginUser $request)
    {
        try {
            return $this->UserService->login($request);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function profile(Request $request){
        return response()->json([
            'status' => 'success',
            'message'=> 'Yout profile is as follows',
            'data' => Auth::user(),
        ]);
    }
    public function logOut(Request $request)
    {
        try {
            $this->UserService->logOut($request);
            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
