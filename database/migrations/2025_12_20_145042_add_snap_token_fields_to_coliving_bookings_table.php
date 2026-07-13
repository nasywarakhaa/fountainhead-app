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
        Schema::table('coliving_bookings', function (Blueprint $table) {
            $table->string('snap_token', 255)->nullable();
            $table->timestamp('snap_token_created_at')->nullable();
            $table->timestamp('snap_token_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coliving_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'snap_token_created_at',
                'snap_token_expires_at',
            ]);
        });
    }
};
