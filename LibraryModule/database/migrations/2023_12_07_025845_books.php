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
        Schema::create('books', function (Blueprint $table) {
            $table->string('call_number');
            $table->string('author');
            $table->string('title');
            $table->string('publish_location');
            $table->date('publish_date');
            $table->integer('available_copies');
            $table->string('sublocation');
            $table->string('book_description');

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
