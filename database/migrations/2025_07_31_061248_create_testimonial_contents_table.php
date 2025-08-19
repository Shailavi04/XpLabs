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
        Schema::create('testimonial_contents', function (Blueprint $table) {
            $table->id();
            $table->text('about')->nullable();
            $table->text('title')->nullable();
            $table->string('rating')->nullable();
            $table->string('rating_text')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonial_contents');
    }
};
