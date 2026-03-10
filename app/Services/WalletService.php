<?php

namespace App\Services;

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
            "status" => "success",
            "message" => "Wallet created !",
            "data" => Wallet::find($wallet->id),
        ]);
    }

    public function show($id)
    {
        $wallet = Wallet::find($id);

        if ($wallet == null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You have no such wallet'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $wallet
        ], 200);
    }

    public function deposit($id, $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric'
        ]);
        $amount = $validated['amount'];

        $wallet = Wallet::find($id);

        if ($wallet == null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You have no such wallet'
            ]);
        }

        $wallet->sold += $amount;
        $wallet->save();

        return response()->json([
            'status' => 'success',
            'message' => "$amount was deposited in $wallet->title wallet, your new sold is: $wallet->sold $",
            'data' => $wallet
        ], 200);
    }


    public function withdraw($id, $request)
    {

        $validated = $request->validate([
            'amount' => 'required|numeric'
        ]);
        $amount = $validated['amount'];

        $wallet = Wallet::find($id);

        if ($wallet == null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You have no such wallet'
            ]);
        }

        if ($wallet->sold < $amount) {
            return response()->json([
                'status' => 'fail',
                'message' => "You don't have enough sold in your wallet, your sold is: $wallet->sold $"
            ]);
        }


        $wallet->sold -= $amount;
        $wallet->save();

        return response()->json([
            'status' => 'success',
            'message' => "$amount was withdrawn from $wallet->title wallet, your new sold is: $wallet->sold $",
            'data' => $wallet
        ], 200);
    }
}
