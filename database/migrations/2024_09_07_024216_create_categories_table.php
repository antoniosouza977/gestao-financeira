<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
    {
		Schema::create('categories', function(Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->tinyInteger('type');
            $table->unsignedBigInteger('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
    {
		Schema::drop('categories');
	}
};
