<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feeders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name')->nullable();
            $table->boolean('status')->default(false);
            $table->string('code');
            $table->string('model')->nullable();
            $table->date('last_fed_at')->nullable();
            $table->string('device_token')->unique();

            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('feeder_id')
                ->constrained('feeders')
                ->cascadeOnDelete();

            $table->time('time');
            $table->integer('quantity');
            $table->string('type');
            $table->json('days')->nullable();

            $table->timestamps();
        });

        Schema::create('feeding_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('feeder_id')
                ->constrained('feeders')
                ->cascadeOnDelete();

            $table->integer('quantity');
            $table->integer('status'); // consider enum if you have fixed states
            $table->string('notes')->nullable();

            $table->date('date');
            $table->time('hour');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('feeders');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('feeding_logs');
    }
};

