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
        Schema::create('task_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable(false);
            $table->integer('step_no')->nullable(false);
            $table->string('step_details', 500)->nullable(false)->default('text');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_details');
    }
};
