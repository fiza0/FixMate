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
        Schema::create('handyman_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handyman_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->boolean('is_primary')->default(false);
            $table->integer('experience_years')->default(0);
            $table->timestamps();
            
            $table->unique(['handyman_id', 'service_id']);
            $table->index('is_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handyman_services');
    }
};
