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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('project_members');
        Schema::dropIfExists('project_notes');
        Schema::dropIfExists('ticket_users');
        Schema::dropIfExists('ticket_comments');
        Schema::dropIfExists('ticket_histories');
        Schema::dropIfExists('external_access');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_statuses');
        Schema::dropIfExists('ticket_priorities');
        Schema::dropIfExists('epics');
        Schema::dropIfExists('projects');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not meant to be reversible.
        throw new \Exception('This migration to remove project management tables is not reversible.');
    }
};