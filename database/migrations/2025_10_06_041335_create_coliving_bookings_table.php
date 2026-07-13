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
        Schema::create('coliving_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coliving_room_id')->constrained('coliving_rooms')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Customer Info
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Booking Details
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('total_nights'); // dihitung otomatis
            $table->integer('number_of_guests')->default(1);

            // Pricing
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('subtotal', 12, 2); // nights * price_per_night
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2);

            // Payment & Status
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('booking_status', ['confirmed', 'cancelled', 'completed', 'no_show'])->default('confirmed');
            $table->string('payment_reference')->nullable(); // Midtrans order_id
            $table->timestamp('paid_at')->nullable();

            // Additional Info
            $table->text('special_requests')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();

            // Indexes untuk performa query
            $table->index(['check_in_date', 'check_out_date']);
            $table->index('payment_status');
            $table->index('booking_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coliving_bookings');
    }
};
