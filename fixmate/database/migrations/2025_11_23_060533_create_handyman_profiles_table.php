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
        Schema::create('handyman_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('skill_category', ['plumber', 'electrician', 'carpenter', 'mechanic', 'painter', 'general']);
            $table->text('bio')->nullable();
            $table->decimal('min_rate', 8, 2);
            $table->decimal('max_rate', 8, 2)->nullable();
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->string('location');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handyman_profiles');
    }
};
