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
        Schema::create('investment_settings', function (Blueprint $table) {
        $table->id();
        $table->decimal('transaction_fee', 5, 2)->default(0);
        $table->decimal('investment_processing_fee', 5, 2)->default(0);
        $table->decimal('interest_rate', 5, 2)->default(0);
        $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_settings');
    }
};
