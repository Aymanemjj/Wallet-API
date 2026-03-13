<?php

namespace App\Services;

use App\Http\Resources\DWResource;
use App\Http\Resources\WalletResource;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store($request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;

        $wallet = Wallet::create($validated);

        return response()->json([
            "success" => true,
            "message" => "Wallet created !",
            "data" => ["wallet" => Wallet::find($wallet->id)],
        ], 201);
    }

    public function show($id)
    {
        $wallet = Wallet::find($id);

        if ($wallet == null) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet introuvable'
            ], 404);
        }
        if ($wallet->user_id != Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => "Vous n'êtes pas autorisé à accéder à ce wallet"
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $wallet
        ], 200);
    }

    public function deposit($id, $request)
    {
        $validated = $request->validated();
        $validated['wallet_id'] = $id;
        $validated['type'] = 'deposit';


        $wallet = Wallet::find($id);

        if ($wallet == null) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet introuvable'
            ], 404);
        }

        $validated['balance_after'] = $wallet->balance + $validated['amount'];

        if ($wallet->user_id != Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => "Vous n'êtes pas autorisé à accéder à ce wallet"
            ], 403);
        }
        $transaction = Transaction::create($validated);
        $wallet->balance += $transaction->amount;
        $wallet->save();

        return response()->json([
            'success' => true,
            'message' => "Dépôt effectué avec succès",
            'data' => ["transaction" => DWResource::make($transaction), "wallet" => WalletResource::make($wallet)]
        ], 200);
    }


    public function withdraw($id, $request)
    {

        $validated = $request->validated();
        $validated['wallet_id'] = $id;
        $validated['type'] = 'withdraw';
        $wallet = Wallet::find($id);

        if ($wallet == null) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet introuvable'
            ], 404);
        }
        if ($wallet->user_id != Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => "Vous n'êtes pas autorisé à accéder à ce wallet"
            ], 403);
        }
        if ($wallet->balance < $validated['amount']) {
            return response()->json([
                'success' => false,
                'message' => "Solde insuffisant. Solde actuel : $wallet->balance $"
            ], 400);
        }

        $validated['balance_after'] = $wallet->balance - $validated['amount'];
        $transaction = Transaction::create($validated);

        $wallet->balance -= $transaction->amount;
        $wallet->save();

        return response()->json([
            'success' => true,
            'message' => "Retrait effectué avec succès.",
            'data' => ["transaction" => DWResource::make($transaction), "wallet" => WalletResource::make($wallet)]
        ], 200);
    }
}
