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
        Schema::table('announcements', function (Blueprint $table) {
            // Rename 'name' to 'title'
            $table->renameColumn('name', 'title');
        });

        Schema::table('announcements', function (Blueprint $table) {
            // Add missing columns
            $table->text('content')->nullable()->after('title');
            $table->string('image')->nullable()->after('content');
            $table->foreignId('created_by')->nullable()->after('image')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['content', 'image', 'created_by']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
        });
    }
};
