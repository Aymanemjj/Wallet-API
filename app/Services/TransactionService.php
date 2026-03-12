<?php

namespace App\Services;

use App\Http\Resources\TransactionInResource;
use App\Http\Resources\TransactionOutResource;
use App\Http\Resources\WalletResource;
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
        $validated['sender_wallet_id'] = $id;
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


        $transaction_out =  Transaction::create([
            'amount'=> $validated['amount'],
            'type'=>"transfer_out",
            "wallet_id" => $id,
            "receiver_wallet_id"=>$validated['receiver_wallet_id'],
            "description"=>$validated['description'],
            "balance_after"=>$Owallet['balance'] - $validated['amount'],
        ]);
        $transaction_in=Transaction::create([
            'amount'=> $validated['amount'],
            'type'=>"transfer_in",
            "wallet_id" => $validated['receiver_wallet_id'],
            "sender_wallet_id"=>$id,
            "description"=>$validated['description'],
            "balance_after"=>$Dwallet['balance'] - $validated['amount'],
        ]);
        $this->calculate($Owallet, $Dwallet, $validated);

        return response()->json([
            'success' => 'success',
            'message' => "Transfert effectué avec succès",
            'data'=> ['transaction_out'=>TransactionOutResource::make($transaction_out), 'transaction_in'=>TransactionInResource::make($transaction_in), 'wallet'=>WalletResource::make($Owallet)]
        ]);
    }

    public function calculate($Owallet, $Dwallet, $validated)
    {
        $Owallet->balance -= $validated['amount'];
        $Owallet->save();
        $Dwallet->balance += $validated['amount'];
        $Dwallet->save();
    }
}
