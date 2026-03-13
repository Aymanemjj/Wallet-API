<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransaction;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\TransactionHistoryResource;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\TransactionService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function store($id, StoreTransaction $request)
    {
        try {
            return $this->TransactionService->store($id, $request);
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
        if (!Wallet::exists($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Ressource introuvable',
            ], 404);
        }

        if (Auth::user()->isOwner($id) == false) {
            return response()->json([
                'success' => false,
                'message' => "Vous n'êtes pas autorisé à effectuer cette action"

            ]);
        }

        $transactions = Transaction::where('wallet_id', $id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Historique des transactions récupéré',
            'data' => TransactionHistoryResource::collection($transactions)

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
