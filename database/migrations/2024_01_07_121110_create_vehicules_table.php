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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 1000)->nullable();
            $table->string('marque', 1000)->nullable();
            $table->string('modele', 1000)->nullable();
            $table->string('couleur', 1000)->nullable();
            $table->string('numeroserie', 1000)->nullable();
            $table->string('type', 1000)->nullable();
            $table->string('carburent', 1000)->nullable();
            $table->string('statut', 10)->default('Activé');
            $table->string('userid', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
