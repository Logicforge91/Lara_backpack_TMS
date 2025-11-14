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
        Schema::table('current_releases', function (Blueprint $table) {
            if (Schema::hasColumn('current_releases', 'status')) {
                $table->enum('status', ['Pending', 'In Progress', 'Released', 'Completed'])
                      ->default('Pending')
                      ->change();
            } else {
                $table->enum('status', ['Pending', 'In Progress', 'Released', 'Completed'])
                      ->default('Pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('current_releases', function (Blueprint $table) {
            // Rollback: change back to string or previous status
            if (Schema::hasColumn('current_releases', 'status')) {
                $table->string('status')->default('Pending')->change();
            }
        });
    }
};
