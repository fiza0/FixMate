<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('handymen', function (Blueprint $table) {
            $table->string('business_name')->nullable()->after('user_id');
            $table->string('avatar')->nullable()->after('bio');
            $table->decimal('hourly_rate', 8, 2)->default(0)->after('bio'); // Replaces min/max
            $table->decimal('latitude', 10, 7)->nullable()->after('hourly_rate');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('address')->nullable()->after('longitude');
            $table->decimal('rating', 3, 2)->default(0)->after('address'); // Replaces average_rating
            $table->integer('total_reviews')->default(0)->after('rating');
            $table->integer('completed_jobs')->default(0)->after('total_reviews');
            $table->boolean('is_available')->default(true)->after('completed_jobs');
            $table->boolean('is_verified')->default(false)->after('is_available');

            $table->index(['latitude', 'longitude']);
            $table->index('is_available');
            $table->index('rating');
            $table->index('hourly_rate');

            // 2. DROP old columns
            $table->dropColumn('skill_category');
            $table->dropColumn('min_rate');
            $table->dropColumn('max_rate');
            $table->dropColumn('average_rating');
            $table->dropColumn('location');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('handymen', function (Blueprint $table) {
            Schema::dropIfExists('handymen');
        });
    }
};
