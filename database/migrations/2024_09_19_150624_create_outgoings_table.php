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
        Schema::create('outgoings', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->text('description')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->unsignedBigInteger('budget_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('budget_id')->references('id')->on('budgets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgos');
    }
};
