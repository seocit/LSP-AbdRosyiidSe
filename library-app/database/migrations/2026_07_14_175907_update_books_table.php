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
        Schema::table('books', function (Blueprint $table) {
            // Rename existing columns to match schema
            $table->renameColumn('name', 'title');
            $table->renameColumn('year', 'publish_year');
            $table->renameColumn('cover_image', 'cover');
        });

        Schema::table('books', function (Blueprint $table) {
            // Add missing columns
            $table->string('isbn')->nullable()->after('publish_year');
            $table->integer('stock')->default(0)->after('isbn');
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'stock']);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->renameColumn('publish_year', 'year');
            $table->renameColumn('cover', 'cover_image');
        });
    }
};
