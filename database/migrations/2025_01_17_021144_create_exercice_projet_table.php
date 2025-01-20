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
        Schema::create('exercice_projet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // Colonne 'projet_id' avec liaison possible
            $table->string('numero_e'); // Colonne 'numero_e' pour le numéro d'exercice
            $table->string('montant_e'); // Colonne 'montant_e' avec précision pour les montants
            $table->string('statut')->default('actif'); // Colonne 'statut' avec une valeur par défaut
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercice_projet');
    }
};
