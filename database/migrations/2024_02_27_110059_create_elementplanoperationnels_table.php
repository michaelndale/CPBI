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
        Schema::create('elementplanoperationnels', function (Blueprint $table) {
            $table->id();
            $table->string('projetref', 11)->nullable();
            $table->string('plano', 1000)->nullable();
            $table->string('lieu', 1000)->nullable();
            $table->string('categoriebeneficie', 1000)->nullable();
            $table->string('nombrebeneficiere', 11)->nullable();
            $table->string('nombreseace', 11)->nullable();
            $table->string('restedatejour', 11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementplanoperationnels');
    }
};
