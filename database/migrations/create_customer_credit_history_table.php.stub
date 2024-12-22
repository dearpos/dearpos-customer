<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_credit_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->enum('transaction_type', ['increase', 'decrease', 'adjustment']);
            $table->decimal('amount', 15, 4);
            $table->enum('reference_type', ['sales_order', 'payment', 'credit_note', 'manual']);
            $table->uuid('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->uuid('created_by');
            $table->timestamps();

            $table->index('customer_id');
            $table->index(['reference_type', 'reference_id']);
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_credit_history');
    }
};
