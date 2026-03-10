<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    Use SoftDeletes;
    protected $fillable = ['amount', 'origin_wallet_id', 'destination_wallet_id'];
}
