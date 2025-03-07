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
        Schema::create('element_entretiens', function (Blueprint $table) {
            $table->id();
            $table->string('entretienid');
            $table->string('libelle');
            $table->string('unite');
            $table->string('quantite');
            $table->string('prixunite');
            $table->string('prixtotal'); 
            $table->integer('userid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_entretiens');
    }
};
