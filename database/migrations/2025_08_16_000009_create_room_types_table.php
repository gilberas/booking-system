<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('max_occupancy');
            $table->unsignedSmallInteger('num_beds')->default(1);
            $table->string('bed_type')->default('queen');
            $table->decimal('base_price', 10, 2);
            $table->unsignedSmallInteger('size_sqft')->nullable();
            $table->unsignedSmallInteger('num_rooms_total')->default(1);
            $table->boolean('is_smoking')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['hotel_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
