<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;

class TransactionService
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

        $Owallet = Wallet::find($validated['origin_wallet_id']);
        $Dwallet = Wallet::find($validated['destination_wallet_id']);

        if ($Owallet == null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You have no such wallet'
            ]);
        }

        if ($Owallet->sold < $validated['amount']) {
            return response()->json([
                'status' => 'fail',
                'message' => "You don't have enough sold in your wallet, your sold is: " . $Owallet->sold . "$"
            ]);
        }

        if ($Dwallet == null) {
            return response()->json([
                'status' => 'fail',
                'message' => "Destination wallet doesn't exist"
            ]);
        }

        $transaction =  Transaction::create($validated);

        $this->calculate($Owallet, $Dwallet, $transaction);

        return response()->json([
            'status' => 'success',
            'message' => "$transaction->amount was withdrawn from " . $Owallet->title . "wallet, your new sold is: " . $Owallet->sold . "$, and was sent to " . $Dwallet->title . "'s wallet",
        ]);
    }

    public function calculate($Owallet, $Dwallet, $transaction)
    {

        $Owallet->sold -= $transaction->amount;
        $Owallet->save();
        $Dwallet->sold += $transaction->amount;
        $Dwallet->save();
    }
}
