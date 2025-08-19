<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenueConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('revenue_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type');
            $table->enum('revenue_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('revenue_value', 8, 2); // percentage (e.g., 5.00) or fixed value (e.g., 5.00)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_configurations');
    }
};
