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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('multiple_choice');
            $table->text('text');
            $table->text('code_snippet')->nullable();
            $table->text('answer_explanation')->nullable();
            $table->string('more_info_link')->nullable();
            $table->boolean('multiple_answers')->default(false);
            $table->integer('points')->default(1);
            $table->integer('time_limit')->nullable();
            $table->string('difficulty')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
