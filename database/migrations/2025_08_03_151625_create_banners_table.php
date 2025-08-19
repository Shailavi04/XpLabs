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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->default(0);
            $table->string('heading');
            $table->string('subheading')->nullable();
            $table->text('description')->nullable();
            $table->string('review_title')->nullable();
            $table->string('rating')->nullable();
            $table->string('review_text')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
