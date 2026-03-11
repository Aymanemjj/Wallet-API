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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float("amount");
            $table->foreignId('sender_wallet_id')->nullable()->constrained(
                table: 'wallets'
            );
            $table->foreignId('receiver_wallet_id')->nullable()->constrained(
                table: 'wallets'
            );

            $table->foreignId('wallet_id')->constrained(table:'wallets');
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
        Schema::dropIfExists('transactions');
    }
};
