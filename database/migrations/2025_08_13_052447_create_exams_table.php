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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('exam_date');
            $table->integer('duration'); // in minutes
            $table->enum('mode', ['online', 'offline']);
            $table->string('location')->nullable(); // only for offline
            $table->string('online_link')->nullable(); // only for online
            $table->string('batch_id')->nullable();
            $table->integer('passing_marks')->default(40);
            $table->string('correct_answer_mark')->nullable();
            $table->string('incorrect_answer_mark')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
