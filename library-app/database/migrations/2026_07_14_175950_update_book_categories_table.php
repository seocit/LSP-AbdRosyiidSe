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
        Schema::table('book_categories', function (Blueprint $table) {
            // Change description from string to text
            $table->text('description')->nullable()->change();
            // Drop slug column (not in schema)
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_categories', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->string('slug')->unique()->nullable();
        });
    }
};
