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
       Schema::create('cash_advance_history', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cash_advance_id');
        $table->decimal('repaid_amount', 15, 2); // Repayment amount
        $table->enum('transaction_status', ['paid', 'failed']);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_advance_history');
    }
};
