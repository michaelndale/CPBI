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
        Schema::create('bonpetitcaisses', function (Blueprint $table) {
            $table->id();
            $table->integer('projetid')->nullable();
            $table->integer('exercice_id')->nullable();
            $table->string('numero')->nullable();  
            $table->string('total_montant')->nullable(); 
            $table->date('date')->nullable();  
            $table->string('titre', 225)->nullable(); 
            $table->string('type_identite', 100)->nullable(); 
            $table->string('adresse', 100)->nullable(); 
            $table->string('numero_piece', 20)->nullable(); 
            $table->string('telephone_email', 70)->nullable(); 
            $table->integer('compteid')->nullable();
            $table->integer('userid')->nullable();
            $table->integer('etabli_par')->nullable();
            $table->integer('verifie_par')->nullable();
            $table->integer('approuve_par')->nullable();
            $table->integer('etabli_par_signature')->nullable();
            $table->integer('verifie_par_signature')->nullable();
            $table->integer('approuve_par_signature')->nullable();
            $table->string('nom_sousigne')->nullable();
            $table->string('beneficiaire')->nullable();
            $table->string('faita')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonpetitcaisses');
    }
};
