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
        Schema::create('enrollment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('center_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->string('enrollment_id', 12);
            $table->string('student_icard', 50)->nullable();
            $table->decimal('token_amount', 10, 2)->default(0);
            $table->tinyInteger('status')->default(1)->comment('Enrollment Status: 1 = pending, 2 = enrolled, 3 = completed, 4 = dropped, 5 = cancelled, 6 = hold');
            $table->tinyInteger('payment_status')->default(0);
            $table->string('remarks', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment');
    }
};
