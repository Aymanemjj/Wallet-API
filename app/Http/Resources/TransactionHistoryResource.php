<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'wallet_id'     => $this->wallet_id,
            'type'          => $this->type,
            'amount'        => $this->amount,
            'description'   => $this->description,
            'receiver_wallet_id'   => $this->receiver_wallet_id,
            'sender_wallet_id'   => $this->sender_wallet_id,
            'balance_after' => $this->balance_after,
            'created_at'    => $this->created_at,
        ];
    }
}
