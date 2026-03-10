<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    Use SoftDeletes;

    protected $fillable = ['title', 'password', 'currency', 'user_id'];
}
