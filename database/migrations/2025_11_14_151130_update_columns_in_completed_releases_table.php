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
        Schema::table('completed_releases', function (Blueprint $table) {

            // Drop name column if exists
            if (Schema::hasColumn('completed_releases', 'name')) {
                $table->dropColumn('name');
            }

            // Add employee_id if missing
            if (!Schema::hasColumn('completed_releases', 'employee_id')) {
                $table->unsignedBigInteger('employee_id')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('completed_releases', function (Blueprint $table) {

            // Restore name column
            if (!Schema::hasColumn('completed_releases', 'name')) {
                $table->string('name')->nullable();
            }

            // Drop employee_id
            if (Schema::hasColumn('completed_releases', 'employee_id')) {
                $table->dropColumn('employee_id');
            }
        });
    }
};
