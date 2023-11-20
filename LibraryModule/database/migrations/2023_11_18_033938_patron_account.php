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
        Schema::create('patron_account', function(Blueprint $table){
            // account credentials
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('id_number');
            $table->string('password');

            // account status
            $table->integer('fines');
            $table->string('holds');

            // account history
            $table->string('books_borrowed');
            $table->date('checked_out_date');
            $table->date('checked_in_date');
            $table->date('due_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
