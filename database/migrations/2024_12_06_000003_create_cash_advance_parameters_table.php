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
       Schema::create('cash_advance_parameters', function (Blueprint $table) {
        $table->id();
        $table->decimal('interest_rate', 5, 2); // 10% interest rate
        $table->decimal('service_fee_percentage', 5, 2); // Percentage service fee
        $table->decimal('fixed_service_fee', 10, 2); // Fixed service fee
        $table->integer('duration_days'); // Duration for repayment
        $table->integer('repayment_period'); // Repayment period in days
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_advance_parameters');
    }
};
