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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('duration');
            $table->text('description');
            $table->boolean('status')->default(1)->comment("1= active , 2 = inactive");
            $table->string('image')->nullable();
            $table->longText('curriculum')->nullable();
            $table->decimal('total_fee', 10, 2);
            $table->integer('seats_available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
