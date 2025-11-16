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
    Schema::table('tasks', function (Blueprint $table) {
        $table->boolean('is_recurring')->default(false);
        $table->enum('recurring_type', ['daily', 'weekly', 'monthly'])->nullable();
        $table->date('recurring_start_date')->nullable();
        $table->date('recurring_end_date')->nullable();
        $table->date('next_run_date')->nullable();
    });
}

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropColumn([
            'is_recurring',
            'recurring_type',
            'recurring_start_date',
            'recurring_end_date',
            'next_run_date'
        ]);
    });
}

};
