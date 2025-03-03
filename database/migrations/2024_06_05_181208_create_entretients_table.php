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
        Schema::create('entretients', function (Blueprint $table) {
            $table->id();
            $table->string('vehicule_id');
            $table->string('typeEntretien');
            $table->string('descriptionTravaux');
            $table->string('kilometrage');
            $table->string('fournisseur');
            $table->string('dateEntretien');
            $table->string('cout');
            $table->integer('userid')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entretients');
    }
};
