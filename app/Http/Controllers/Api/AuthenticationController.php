<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\StoreUser;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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
                'success' => true,
                'message' => 'Inscription réussie.',
                'data' => $this->UserService->register($request)
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginUser $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie.',
                'data' =>  $this->UserService->login($request)
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Profil utilisateur récupéré',
            'data' => ["user"=>Auth::user()],
        ],200);
    }
    public function logOut(Request $request)
    {
        try {
            $this->UserService->logOut($request);
            return response()->json([
                'success' => true,
                'message' => 'Déconnexion réussie.',
            ], 200);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
