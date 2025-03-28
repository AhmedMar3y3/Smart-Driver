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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->bigInteger('distance');
            $table->year('year');
            $table->tinyInteger('type')->default(0);
            $table->bigInteger('price');
            $table->string('color');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('additional_info')->nullable();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
