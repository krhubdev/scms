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
        Schema::create('t_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('eval_student_id');
            $table->foreignId('eval_event_id')->constrained('t_events')->onDelete('cascade');
            $table->integer('eval_rating')->unsigned();
            $table->text('eval_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_evaluations');
    }
};
