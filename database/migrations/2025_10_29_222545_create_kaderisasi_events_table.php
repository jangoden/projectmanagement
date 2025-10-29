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
        Schema::create('kaderisasi_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pac_id')->constrained('pacs')->onDelete('cascade');
            $table->enum('event_type', ['makesta', 'lakmud']);
            $table->string('name');
            $table->string('venue')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('certificate_start_number')->default(1);
            $table->string('certificate_format');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kaderisasi_events');
    }
};
