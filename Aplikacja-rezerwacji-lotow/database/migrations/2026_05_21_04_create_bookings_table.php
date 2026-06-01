<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Casts\AsEnum;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');

            $table->string('booking_reference')->unique();

            $table->string('status')->default('pending');
            // pending, awaiting_payment, paid, cancelled

            $table->integer('passengers_count');
            $table->decimal('total_price', 10, 2);
            $table->string('currency', 3)->default('USD');

            $table->json('flight_data');

            $table->dateTime('expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }

};
