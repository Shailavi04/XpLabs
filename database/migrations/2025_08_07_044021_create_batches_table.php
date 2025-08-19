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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('course_id');
            $table->string('instructor_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('schedule')->nullable();
            $table->boolean('status')->comment('1 for upcoming', ' 2 for ongoing', '3 for completed', '4 for cancelled')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
