<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWallet;
use App\Models\Wallet;
use App\Services\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{


    private WalletService $WalletService;

    public function __construct(WalletService $WalletService)
    {
        $this->WalletService = $WalletService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Here are all your wallets',
            'data' => $wallets
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWallet $request)
    {
        try {
            return $this->WalletService->store($request);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            return $this->WalletService->show($id);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deposit($id, $amount)
    {
        try {
            return $this->WalletService->deposit($id, $amount);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function withdraw($id, $amount)
    {
        try {
            return $this->WalletService->withdraw($id, $amount);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
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
