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
        Schema::rename('account_history', 'library_account_history');
        Schema::rename('pending_requests', 'library_pending_requests');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
