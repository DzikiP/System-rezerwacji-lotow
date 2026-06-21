<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// xxxx_create_payments_table.php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->string('provider')->default('p24');

            $table->string('gateway_session_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('p24_order_id')->nullable();

            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('PLN');

            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])
                ->default('pending');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'provider']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
