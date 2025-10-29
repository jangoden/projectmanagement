<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_statuses', function (Blueprint $table) {
            $table->boolean('is_completed')->default(false)->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_statuses', function (Blueprint $table) {
            $table->dropColumn('is_completed');
        });
    }
};