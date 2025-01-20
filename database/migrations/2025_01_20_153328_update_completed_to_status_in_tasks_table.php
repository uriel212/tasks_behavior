<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->renameColumn('completed', 'status');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->string('status', 255)->default('pending')->change();
        });

        DB::statement("ALTER TABLE tasks ADD CONSTRAINT status_check CHECK (status IN ('pending', 'in_progress', 'completed'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE tasks DROP CONSTRAINT status_check");

        Schema::table('tasks', function (Blueprint $table) {
            $table->renameColumn('status', 'completed');
            $table->boolean('completed')->default(false)->change();
        });
    }
};
