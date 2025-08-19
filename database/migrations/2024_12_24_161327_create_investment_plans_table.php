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
        Schema::create('investment_plans', function (Blueprint $table) {
        $table->id();
        $table->string('package_name');
        $table->enum('investment_type', ['daily', 'weekly', 'monthly']);
        $table->integer('duration')->comment('Duration in days');
        $table->decimal('min_amount', 15, 2);
        $table->decimal('max_amount', 15, 2);
        $table->enum('return_term', ['2 hours', '1 week', '1 year']);
        $table->boolean('withdraw_after_mature')->default(false);
        $table->enum('capital_return', ['term basis', 'after matured']);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_plans');
    }
};
