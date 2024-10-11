<?php

use App\Models\Transaction;
use App\Models\TransactionPromise;
use Illuminate\Database\Eloquent\Collection;
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
        Transaction::query()
            ->chunkById(50, function (Collection $transactions) {
           foreach ($transactions as $transaction) {
               $transaction->update([
                   'value' =>  number_format($transaction->value, 2, '.', ''),
               ]);
           }
        });

        TransactionPromise::query()
            ->chunkById(50, function (Collection $transactions) {
                foreach ($transactions as $transaction) {
                    $transaction->update([
                        'value' =>  number_format($transaction->value, 2, '.', ''),
                    ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
