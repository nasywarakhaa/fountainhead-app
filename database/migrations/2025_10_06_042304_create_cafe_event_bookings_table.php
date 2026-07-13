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
        Schema::create('cafe_event_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Customer Info
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('organization_name')->nullable(); // untuk corporate event

            // Event Details (yang USER bikin)
            $table->string('event_name'); // nama event yang mau dibikin user
            $table->text('event_description');
            $table->enum('event_type', ['birthday', 'meeting', 'workshop', 'party', 'wedding', 'corporate', 'other']);
            $table->integer('expected_guests'); // perkiraan jumlah tamu

            // Booking Details
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_hours'); // dihitung otomatis

            // Space & Services
            $table->enum('space_type', ['indoor', 'outdoor', 'both'])->default('indoor');
            $table->json('additional_services')->nullable(); // catering, decoration, sound system, etc.

            // Pricing
            $table->decimal('venue_price', 12, 2); // harga sewa venue per jam atau paket
            $table->decimal('services_price', 12, 2)->default(0); // harga additional services
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2);

            // Payment & Status
            $table->enum('payment_status', ['pending', 'dp_paid', 'paid', 'failed', 'refunded'])->default('pending');
            $table->decimal('dp_amount', 12, 2)->nullable(); // down payment
            $table->decimal('remaining_amount', 12, 2)->nullable();
            $table->enum('booking_status', ['pending_approval', 'confirmed', 'cancelled', 'completed'])->default('pending_approval');
            $table->string('payment_reference')->nullable(); // Midtrans order_id
            $table->timestamp('paid_at')->nullable();

            // Additional Info
            $table->text('special_requirements')->nullable(); // kebutuhan khusus
            $table->text('admin_notes')->nullable(); // catatan dari admin
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');

            $table->timestamps();

            // Indexes
            $table->index('event_date');
            $table->index('payment_status');
            $table->index('booking_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafe_event_bookings');
    }
};
