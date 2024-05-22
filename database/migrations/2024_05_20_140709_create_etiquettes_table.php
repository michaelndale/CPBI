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
        Schema::create('etiquettes', function (Blueprint $table) {
            $table->id();
            $table->integer('classeur_id')->nullable();
            $table->string('nom_e')->nullable();
            $table->string('info_bulle')->nullable();
            $table->integer('userid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etiquettes');
    }
};
