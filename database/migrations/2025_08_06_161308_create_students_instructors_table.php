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
        Schema::create('students_instructors', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('center_id');
            $table->string('emergency_contact')->nullable();
            $table->boolean('qualification')->nullable(); 
            $table->string('designation')->nullable(); 
            $table->string('profile_image')->nullable(); 
            $table->integer('experience_years')->nullable(); 
            $table->date('joining_date')->nullable();
            $table->text('bio')->nullable(); 
            $table->boolean('active')->default(1)->comment('1 = active, 0 = inactive'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_instructors');
    }
};
