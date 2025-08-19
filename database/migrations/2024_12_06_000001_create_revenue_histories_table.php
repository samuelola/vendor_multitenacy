<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenueHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('revenue_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string('transaction_type');
            $table->decimal('revenue_amount', 10, 2);
            $table->string('user_id');
            $table->timestamp('date');
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions'); // assuming you have a transactions table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_histories');
    }
};
