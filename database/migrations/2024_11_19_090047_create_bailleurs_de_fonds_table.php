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
        Schema::create('bailleurs_de_fonds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // BIGINT for user_id
            $table->string('nom', 255); // Nom de l'ONG ou de l'organisation
            $table->string('pays_origine', 100); // Pays d'origine du bailleur
            $table->string('logo')->nullable(); // Logo du bailleur (optionnel)
            $table->string('contact_nom', 255); // Nom de la personne de contact
            $table->string('contact_email')->nullable(); // Email de contact
            $table->string('contact_telephone')->nullable(); // Téléphone de contact
            $table->string('site_web')->nullable(); // Site web du bailleur
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bailleurs_de_fonds');
    }
};
