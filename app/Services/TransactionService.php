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

    public function store($id,$request)
    {
        $validated = $request->validated();
        $validated['wallet_id'] = $id;
        $validated['type'] = 'transaction';

        $Owallet = Wallet::find($validated['sender_wallet_id']);
        $Dwallet = Wallet::find($validated['receiver_wallet_id']);

        if ($Owallet == null) {
            return response()->json([
                'success' => false,
                'message' => 'Le wallet source est introuvable'
            ], 404);
        }

        if ($Dwallet == null) {
            return response()->json([
                'success' => false,
                'message' => "Le wallet destinataire est introuvable"
            ], 404);
        }

        if ($Dwallet->currency != $Owallet->currency) {
            return response()->json([
                'success' => false,
                'message' => "Transfert impossible : les deux wallets doivent avoir la même devise"
            ], 400);
        }

        if ($Owallet->balance < $validated['amount']) {
            return response()->json([
                'success' => false,
                'message' => "Solde insuffisant. Solde actuel : " . $Owallet->balance . "$"
            ]);
        }


        $transaction =  Transaction::create($validated);

        $this->calculate($Owallet, $Dwallet, $transaction);

        return response()->json([
            'success' => 'success',
            'message' => "$transaction->amount was withdrawn from " . $Owallet->title . "wallet, your new balance is: " . $Owallet->balance . "$, and was sent to " . $Dwallet->title . "'s wallet",
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
