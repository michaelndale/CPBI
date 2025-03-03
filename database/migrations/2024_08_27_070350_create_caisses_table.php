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
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();
            $table->string('projetid', 11)->nullable();
            $table->string('compteid', 11)->nullable();
            $table->string('exercice_id', 11)->nullable();
            $table->string('date', 50)->nullable();
            $table->string('numero', 25)->nullable();
            $table->string('numerobon', 25)->nullable();
            $table->string('description', 225)->nullable();
            $table->string('input', 25)->nullable();
            $table->string('debit', 25)->nullable();
            $table->string('credit', 25)->nullable();
            $table->string('solde', 25)->nullable();
            $table->string('dapid', 25)->nullable();
            $table->string('decid', 25)->nullable();
            $table->string('bonid', 25)->nullable();
            $table->string('statut', 2)->default(0);
            $table->string('userid', 25)->nullable();
            $table->string('etat_avant_signature', 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};
