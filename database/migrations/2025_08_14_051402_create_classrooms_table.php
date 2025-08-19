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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->enum('type', ['online', 'offline', 'hybrid'])->default('offline');
            $table->integer('no_of_seats')->nullable();
            $table->text('description')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('meeting_password')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
