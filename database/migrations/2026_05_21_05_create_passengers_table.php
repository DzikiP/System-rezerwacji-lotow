<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// xxxx_create_passengers_table.php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained('bookings');

            $table->string('first_name');
            $table->string('last_name');

            $table->date('birth_date');
            $table->string('nationality');
            $table->string('document_number');

            $table->string('passenger_type');
            // adult, child, infant

            $table->string('seat_number')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
