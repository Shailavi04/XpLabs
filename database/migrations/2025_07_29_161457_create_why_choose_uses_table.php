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
        Schema::create('why_choose_uses', function (Blueprint $table) {
            $table->id();
            $table->string('main_image')->nullable();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('list_items')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_choose_uses');
    }
};
