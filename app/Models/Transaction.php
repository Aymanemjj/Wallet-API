<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = ['amount', 'origin_wallet_id', 'destination_wallet_id'];

    public function origin()
    {
        return $this->belongsTo(Wallet::class, 'origin_wallet_id');
    }

    public function destination()
    {
        return $this->belongsTo(Wallet::class, 'destination_wallet_id');
    }

    public function owner()
    {
        return $this->origin->user();
    }
}
