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
        Schema::create('t_attendance', function (Blueprint $table) {
            $table->id();
            $table->string('attend_student_id');
            $table->foreignId('attend_event_id')->constrained('t_events')->onDelete('cascade');
            $table->dateTime('attend_checked_in_at');
            $table->dateTime('attend_checked_out_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_attendance');
    }
};
