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
        Schema::create('carnetbords', function (Blueprint $table) {
            $table->id();
            $table->text('numero_plaque')->nullable();
            $table->text('service_id')->nullable();
            $table->text('itineraire')->nullable();
            $table->text('objectmission')->nullable();
            $table->text('chefmission')->nullable();
            $table->text('projetid')->nullable();
            $table->text('index_depart')->nullable();
            $table->text('index_retour')->nullable();
            $table->text('kms_parcourus')->nullable();
            $table->text('carburant_littre')->nullable();
            $table->text('signature_mission')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carnetbords');
    }
};
