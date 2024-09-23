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
        Schema::create('transaction_promises', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->text('description')->nullable();
            $table->string('type', 1);
            $table->string('status', 1)->default('0');
            $table->string('period_type', 1);
            $table->string('period_value', 4)->nullable();
            $table->dateTime('last_confirmation')->nullable();
            $table->boolean('active')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_promises');
    }
};
