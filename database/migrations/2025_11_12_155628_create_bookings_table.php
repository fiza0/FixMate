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
         $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('handyman_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('service_id')->constrained();
            
            // Booking type: 'now' or 'scheduled'
            $table->enum('booking_type', ['now', 'scheduled'])->default('now');
            
            // Status: pending, accepted, declined, en_route, in_progress, completed, cancelled
            $table->enum('status', [
                'pending',
                'accepted',
                'declined',
                'en_route',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('pending');
            
            // Customer details
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            
            // Service location
            $table->string('service_address');
            $table->string('service_city');
            $table->string('service_state')->nullable();
            $table->string('service_postal_code')->nullable();
            $table->decimal('service_latitude', 10, 7);
            $table->decimal('service_longitude', 10, 7);
            
            // Scheduling
            $table->timestamp('scheduled_start')->nullable();
            $table->timestamp('scheduled_end')->nullable();
            $table->timestamp('actual_start')->nullable();
            $table->timestamp('actual_end')->nullable();
            
            // Service details
            $table->text('description');
            $table->text('special_instructions')->nullable();
            $table->decimal('estimated_hours', 5, 2)->nullable();
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            
            // Payment (placeholder for future integration)
            $table->enum('payment_status', ['pending', 'authorized', 'paid', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_transaction_id')->nullable();
            
            // Tracking
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            
            $table->timestamps();
            
            $table->index('booking_number');
            $table->index(['user_id', 'status']);
            $table->index(['handyman_id', 'status']);
            $table->index('status');
            $table->index('scheduled_start');
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
