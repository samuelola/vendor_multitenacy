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
        Schema::create('escrows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['goods', 'services', 'others']);
            $table->text('description');
            $table->string('currency');
            $table->decimal('amount', 15, 2);
            $table->enum('escrow_type', ['single', 'milestone']);
            $table->json('milestones')->nullable(); // JSON for milestone details
            $table->date('delivery_date')->nullable();
            $table->unsignedBigInteger('originator_id'); // user ID
            $table->unsignedBigInteger('receiver_id')->nullable(); // user ID
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'disputed'])->default('pending');
            $table->text('dispute_reason')->nullable();
            $table->decimal('service_charge', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('originator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escrows');
    }
};
