<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
/*     use SoftDeletes;
 */
    protected $fillable = ['title', 'password', 'currency', 'sold', 'user_id'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
