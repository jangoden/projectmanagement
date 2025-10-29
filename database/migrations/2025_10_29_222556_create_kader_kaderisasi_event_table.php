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
        Schema::create('kader_kaderisasi_event', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kader_id')->constrained('kaders')->onDelete('cascade');
            $table->foreignId('kaderisasi_event_id')->constrained('kaderisasi_events')->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kader_kaderisasi_event');
    }
};
