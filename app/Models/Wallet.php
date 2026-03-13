<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
/*     use SoftDeletes;
 */
    protected $fillable = ['name', 'currency', 'balance', 'user_id'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }


    public static function exists($id){
        return Wallet::find($id) != null;
    }
}
