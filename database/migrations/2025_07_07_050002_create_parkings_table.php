<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('zone_id')->constrained();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('stop_time')->nullable();
            $table->integer('total_price')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('parkings');
    }
};
