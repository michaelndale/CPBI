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
        Schema::create('achat_locations', function (Blueprint $table) {

            $table->id();
            $table->string('location', 225)->nullable();
            $table->string('achat', 225)->nullable();
            $table->string('date', 25)->nullable();
            $table->double('kilometrage', 11)->nullable();
            $table->double('prixvente', 11)->nullable();
            $table->string('note', 1000)->nullable();
            $table->double('vehicule', 11)->nullable();
            $table->string('fournisseur', 225)->nullable();
            $table->integer('userid')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achat_locations');
    }
};
