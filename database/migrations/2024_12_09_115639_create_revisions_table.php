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
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projet_id');  // Lien vers le projet
            $table->decimal('ancien_montant', 15, 2);  // Ancien montant
            $table->decimal('nouveau_montant', 15, 2);  // Nouveau montant
            $table->text('description');  // Description de la révision
            $table->timestamps();  // Pour les colonnes created_at et updated_at

            // Ajout de la contrainte de clé étrangère sur projet_id
            $table->foreign('projet_id')
                  ->references('id')->on('projects')  // Lien vers la table projects
                  ->onDelete('cascade');  // Si un projet est supprimé, les révisions liées seront aussi supprimées
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};
