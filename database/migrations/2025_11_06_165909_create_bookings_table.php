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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homeowner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('handyman_id')->constrained('users')->onDelete('cascade');
            $table->string('service_type');
            $table->text('description');
            $table->timestamp('scheduled_at');
            $table->enum('status', ['requested', 'accepted', 'in_progress', 'completed', 'cancelled'])->default('requested');
            $table->decimal('estimated_cost', 8, 2)->nullable();
            $table->decimal('final_cost', 8, 2)->nullable();
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
