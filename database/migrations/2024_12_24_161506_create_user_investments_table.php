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
        Schema::create('user_investments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('investment_plan_id')->constrained();
        $table->decimal('invested_amount', 15, 2);
        $table->decimal('net_profit', 15, 2)->default(0);
        $table->decimal('total', 15, 2)->default(0);
        $table->timestamp('start_date');
        $table->timestamp('end_date')->nullable();
        $table->enum('status', ['active', 'completed', 'withdrawn'])->default('active');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};
