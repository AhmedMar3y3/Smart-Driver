<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_packages', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->integer('level_order')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('time_limit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_packages');
    }
};