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
        Schema::create('t_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('event_description')->nullable();
            $table->dateTime('event_start_date');
            $table->dateTime('event_end_date')->nullable();
            $table->string('event_location')->nullable();
            $table->int('event_course');
            $table->int('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_events');
    }
};
