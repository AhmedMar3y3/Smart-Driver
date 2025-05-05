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
        Schema::create('captain_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('from');
            $table->time('to');
            $table->boolean('is_reserved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captain_availabilities');
    }
};
