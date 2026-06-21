<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('saved_passengers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name');

            $table->date('birth_date');

            $table->string('nationality');

            $table->string('document_number');

            $table->string('passenger_type');
            // adult, child, infant

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_passengers');
    }
};
