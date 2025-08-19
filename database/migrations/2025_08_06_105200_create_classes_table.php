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
        Schema::create('center', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('state');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('code')->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('longitude')->nullable();
            $table->unsignedBigInteger('latitude')->nullable();
            $table->string('website')->nullable();
            $table->boolean('active')->default('0')->comment('1 = active, 0 = inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
