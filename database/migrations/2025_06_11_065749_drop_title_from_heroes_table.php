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
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'title_en', 'title_ur']);
            $table->string('title')->nullable();
        });
    }
};
