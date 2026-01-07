<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // 後でユーザー機能実装時に使う
            $table->string('fincode_invoice_id', 30)->unique();
            $table->string('invoice_url', 256);
            $table->string('status', 30)->default('DRAFT'); // DRAFT, AWAITING_CUSTOMER_PAYMENT, PAID, CANCELED
            $table->decimal('amount', 10, 0);
            $table->string('customer_name', 100);
            $table->string('customer_email', 100);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
