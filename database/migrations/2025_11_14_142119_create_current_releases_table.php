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
        Schema::create('current_releases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('section')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['Pending', 'In Progress', 'Released'])->default('Pending');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->text('comments')->nullable();
            $table->string('code_verified_by')->nullable();
            $table->integer('story_points')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_releases');
    }
};
