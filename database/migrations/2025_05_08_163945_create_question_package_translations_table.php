<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_package_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_package_id')->constrained('question_packages')->onDelete('cascade');
            $table->string('locale');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unique(['question_package_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_package_translations');
    }
};