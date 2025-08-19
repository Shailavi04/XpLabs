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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('center_id');
            $table->string('icard')->nullable();
            $table->string('user_id');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_contact_number')->nullable();
            $table->string('alternate_contact_number')->nullable();
            $table->string('nationality')->nullable();
            $table->string('education_level')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
