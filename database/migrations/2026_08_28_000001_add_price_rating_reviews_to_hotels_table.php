<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->after('star_rating')->default(0);
            $table->decimal('rating', 3, 1)->after('price')->default(0);
            $table->unsignedInteger('reviews_count')->after('rating')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['price', 'rating', 'reviews_count']);
        });
    }
};
