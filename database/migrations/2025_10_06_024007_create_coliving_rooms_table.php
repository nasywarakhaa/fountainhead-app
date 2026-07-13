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
        Schema::create('coliving_rooms', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name'); // nama kamar (Deluxe Suite, Standard Room, etc)
            $table->string('slug')->unique();
            $table->enum('room_type', ['single', 'double', 'shared', 'suite', 'dormitory'])->default('single');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable(); // untuk card preview

            // Pricing
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('weekly_price', 10, 2)->nullable(); // diskon kalau booking seminggu
            $table->decimal('monthly_price', 12, 2)->nullable(); // diskon kalau booking sebulan

            // Room Details
            $table->integer('capacity')->default(1); // muat berapa orang
            $table->decimal('room_size', 5, 2)->nullable(); // ukuran kamar dalam m²
            $table->integer('beds_count')->default(1); // jumlah tempat tidur
            $table->enum('bed_type', ['single', 'double', 'queen', 'king', 'bunk'])->default('single');
            $table->integer('floor')->nullable(); // lantai berapa
            $table->boolean('has_window')->default(true);
            $table->boolean('has_balcony')->default(false);
            $table->enum('bathroom_type', ['private', 'shared'])->default('private');

            // Facilities (JSON array)
            $table->json('facilities')->nullable(); // AC, WiFi, TV, etc
            $table->json('amenities')->nullable(); // Lemari, meja kerja, dll

            // Images (JSON array of image paths)
            $table->string('thumbnail')->nullable(); // gambar utama
            $table->json('images')->nullable(); // gallery images

            // Availability
            $table->boolean('is_available')->default(true);
            $table->integer('total_units')->default(1); // kalau ada beberapa kamar tipe sama

            // SEO & Marketing
            $table->text('cancellation_policy')->nullable();
            $table->text('house_rules')->nullable();
            $table->integer('sort_order')->default(0); // untuk sorting di list
            $table->boolean('is_featured')->default(false); // featured rooms

            $table->timestamps();

            // Indexes
            $table->index('room_type');
            $table->index('is_available');
            $table->index('is_featured');
            $table->index('price_per_night');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coliving_rooms');
    }
};
