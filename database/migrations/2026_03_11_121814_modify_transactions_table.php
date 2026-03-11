<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('destination_wallet_id', 'receiver_wallet_id');
            $table->renameColumn('origin_wallet_id', 'sender_wallet_id');
            $table->foreignId('wallet_id')->constrained();
            $table->string('description')->nullable();
            $table->string('type');
            $table->float('balance_after');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
