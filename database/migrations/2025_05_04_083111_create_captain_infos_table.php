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
        Schema::create('captain_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->constrained()->onDelete('cascade');
            $table->boolean('has_car')->default(false);
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('ID_card');
            $table->string('country');
            $table->string('address');
            $table->text('bio')->nullable();
            $table->string('driving_license')->nullable();
            $table->string('issued_by')->nullable();
            $table->date('issued_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('vehicle_title')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_plate')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captain_infos');
    }
};
