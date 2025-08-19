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
       Schema::create('cash_advances', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->decimal('amount', 15, 2); // Requested amount
        $table->decimal('interest', 15, 2); // Interest amount
        $table->decimal('total_due', 15, 2); // Total amount due (including interest)
        $table->enum('status', ['pending', 'approved', 'repaid', 'overdue']);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_advances');
    }
};
