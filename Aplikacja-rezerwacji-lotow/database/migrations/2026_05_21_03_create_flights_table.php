<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// xxxx_create_flights_table.php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();

            $table->string('airline');
            $table->string('flight_number');

            $table->string('origin_airport', 3);
            $table->string('destination_airport', 3);

            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');

            $table->integer('duration_minutes')->nullable();

            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('PLN');

            $table->integer('seats_available')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
