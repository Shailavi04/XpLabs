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
        Schema::create('subscription', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->decimal('token_amount', 10, 2)->default(0);
            $table->boolean('is_confirmed')->default(false);
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 = pending, 1 = enrolled, 2 = completed, 3 = dropped');
            $table->integer('total_installments')->nullable();

            $table->integer('installments_paid')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription');
    }
};
