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
        Schema::create('casutilisations', function (Blueprint $table) {
            $table->id();
            $table->string('febid', 1000)->nullable();
            $table->string('projetid', 1000)->nullable();
            $table->string('exerciceid', 1000)->nullable();
            $table->string('ligne_bugdet', 20)->nullable();
            $table->string('sous_ligne_bugdet', 20)->nullable();
            $table->string('periode', 1000)->nullable();
            $table->string('datefeb', 30)->nullable();
            $table->string('beneficiaire', 15)->nullable(); 
            $table->string('autrebeneficiare', 15)->nullable();
            $table->string('userid', 25)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casutilisations');
    }
};
