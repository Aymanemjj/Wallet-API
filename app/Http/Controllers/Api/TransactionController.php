<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransaction;
use App\Models\Transaction;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    private TransactionService $TransactionService;
    public function __construct(TransactionService $TransactionService)
    {
        $this->TransactionService = $TransactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id,StoreTransaction $request)
    {
        try {
            return $this->TransactionService->store($id,$request);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Rtransactions = Transaction::where('receiver_wallet_id', $id)->get();
        $Stransactions = Transaction::where('sender_wallet_id', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Transaction history',
            'sent' => $Stransactions,
            'recieved'=>$Rtransactions,
        ]);
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
