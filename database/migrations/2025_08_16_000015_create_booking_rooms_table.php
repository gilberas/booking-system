<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_type_id')->constrained()->cascadeOnDelete();
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedSmallInteger('adults')->default(1);
            $table->unsignedSmallInteger('children')->default(0);
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->boolean('extra_bed')->default(false);
            $table->decimal('extra_bed_charge', 10, 2)->default(0);
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->index(['room_id', 'check_in', 'check_out', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_rooms');
    }
};
