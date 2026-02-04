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
        Schema::table('event_participants', function (Blueprint $table) {
            // Check if status column exists and modify it, otherwise create it
            if (Schema::hasColumn('event_participants', 'status')) {
                // If column exists, we assume it's already correct
                // You might want to modify this based on your needs
            } else {
                $table->enum('status', ['pending', 'registered', 'confirmed', 'cancelled'])->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_participants', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('status', ['registered', 'confirmed', 'cancelled'])->default('registered');
        });
    }
};
