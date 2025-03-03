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
        Schema::create('responsabilites', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->foreignId('fonction_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table "fonctions"
            $table->string('titre', 255); // Correction de la longueur (255 au lieu de 225)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Nouvelle clé étrangère vers la table "users"
            $table->timestamps(); // Ajoute les champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsabilites');
    }
};
