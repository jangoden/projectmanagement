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
        Schema::create('kaders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pac_id')->constrained('pacs')->onDelete('cascade');
            $table->string('nia')->unique()->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->nullable();
            $table->string('name');
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('hobby')->nullable();
            $table->text('address')->nullable();
            $table->string('village')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->enum('status', ['Aktif', 'Non-Aktif', 'Alumni'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kaders');
    }
};
