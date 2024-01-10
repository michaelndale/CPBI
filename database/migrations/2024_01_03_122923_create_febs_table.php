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
        Schema::create('febs', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 1000)->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('composant', 1000)->nullable();
            $table->string('periode', 1000)->nullable();
            $table->string('activite', 1000)->nullable();
            $table->string('date', 30)->nullable();
            $table->string('ligne_bugdetaire', 20)->nullable();
            $table->string('taux_execution', 1000)->nullable();
            $table->string('fc', 1000)->nullable();
            $table->string('facture', 1000)->nullable();
            $table->string('om', 1000)->nullable();
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('febs');
    }
};
