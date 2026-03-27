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
        Schema::create('piece_material', function (Blueprint $table) {
            $table->id();
            $table->unique(['piece_id', 'material_id']);
            $table->unsignedBigInteger('piece_id');
            $table->unsignedBigInteger('material_id');
            $table->foreign('piece_id')->references('id')->on('pieces')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piece_material');
    }
};
