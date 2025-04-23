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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('question');
            $table->string('score')->default(0);
            $table->string('level')->default('free');
            $table->integer('order');
            $table->bigInteger('group_id')->unsigned();
            $table->string('sequence');
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('question_groups')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
