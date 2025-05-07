<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PlateType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emirate_id')->constrained()->onDelete('cascade');
            $table->integer('number');
            $table->string('type')->default(PlateType::MODERN);
            $table->string('phone');
            $table->text('address')->nullable();
            $table->bigInteger('price')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plates');
    }
};
