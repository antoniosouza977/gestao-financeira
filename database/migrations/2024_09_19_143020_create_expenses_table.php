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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->text('description')->nullable();
            $table->text('payment_day');
            $table->boolean('active')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('budget_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('budget_id')->references('id')->on('budgets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
