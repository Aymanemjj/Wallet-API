<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store($request){
        $validated = $request->validated();

        $wallet = Wallet::create($validated);

        return response()->json([
            "status"=>"success",
            ""
        ]);
    }   
}
