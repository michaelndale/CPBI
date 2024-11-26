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
        Schema::create('comptebanques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banque_id'); // ID de la banque associée
            $table->string('numero_compte')->unique(); // Numéro unique du compte bancaire
            $table->decimal('solde', 15, 2)->default(0); // Solde actuel du compte, avec précision de 15 chiffres et 2 décimales
            $table->string('devise')->nullable();
            $table->timestamps(); // Crée automatiquement les colonnes created_at et updated_at
            // Définir une clé étrangère pour banque_id
            $table->foreign('banque_id')->references('id')->on('banques')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptebanques');
    }
};
