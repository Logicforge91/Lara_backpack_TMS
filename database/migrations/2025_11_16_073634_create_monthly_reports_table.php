<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('monthly_reports', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('task_id');
        $table->unsignedBigInteger('employee_id')->nullable();

        $table->string('task_name')->nullable();
        $table->text('description')->nullable();

        $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Released'])
              ->default('Pending');

        $table->date('report_date');

        $table->timestamps();

        $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('monthly_reports');
}

};
