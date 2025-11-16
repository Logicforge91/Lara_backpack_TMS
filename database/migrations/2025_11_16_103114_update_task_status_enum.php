<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Update enum to include On Hold and Cancelled
            $table->enum('status', [
                'Pending',
                'In Progress',
                'Completed',
                'Released',
                'On Hold',
                'Cancelled'
            ])->default('Pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Remove On Hold and Cancelled
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Released'])
                  ->default('Pending')->change();
        });
    }
};

