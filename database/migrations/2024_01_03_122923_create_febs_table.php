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
            $table->string('numerofeb', 1000)->nullable();
            $table->string('projetid', 1000)->nullable();
            $table->string('activiteid', 1000)->nullable();
            $table->string('periode', 1000)->nullable();
            $table->string('datefeb', 30)->nullable();
            $table->string('ligne_bugdetaire', 20)->nullable();

            $table->string('titre', 1000)->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('composant', 1000)->nullable();
            $table->string('bc', 1000)->nullable();
            $table->string('facture', 1000)->nullable();
            $table->string('om', 1000)->nullable();
            $table->string('acce', 1000)->nullable();
            $table->string('comptable', 1000)->nullable();
            $table->string('chefcomposante', 1000)->nullable();
            $table->string('userid', 25)->nullable();
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
