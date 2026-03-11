<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /*     use SoftDeletes;
 */
    protected $fillable = ['amount', 'sender_wallet_id', 'receiver_wallet_id', "description", "wallet_id", 'type', 'balance_after'];




    public function wallet(){
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function sender()
    {
        return $this->belongsTo(Wallet::class, 'sender_wallet_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Wallet::class, 'receiver_wallet_id');
    }

    public function owner()
    {
        return $this->sender->user();
    }
}
