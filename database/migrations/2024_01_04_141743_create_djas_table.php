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
        Schema::create('djas', function (Blueprint $table) {
            $table->id();
            $table->string('numerodjas', 250)->nullable();
            $table->string('projetiddja', 250)->nullable();
            $table->string('beneficiaire', 250)->nullable();
            $table->string('datefondrecu', 250)->nullable();
            $table->string('numerofeb', 250)->nullable();
            $table->string('numerodap', 250)->nullable();
            $table->string('numeroov', 250)->nullable();
            $table->string('lignebdt', 250)->nullable();
            $table->string('montant_avance', 250)->nullable();
            $table->string('devise', 250)->nullable();
            $table->string('duree_avence', 250)->nullable();
            $table->string('description', 250)->nullable();
            $table->string('fondapprouver', 250)->nullable();
            $table->string('sign_fond', 250)->nullable();
            $table->string('date_fond', 250)->nullable();
            $table->string('avance_approuver', 250)->nullable();
            $table->string('sign_avance', 250)->nullable();
            $table->string('chefcomptable', 250)->nullable();
            $table->string('date_chefcomptable', 250)->nullable();
            $table->string('avence_approuver_deuxieme', 250)->nullable();
            $table->string('signe_deuxieme', 250)->nullable();
            $table->string('raf', 250)->nullable();
            $table->string('date_raf', 250)->nullable();
            $table->string('avence_approuver_troisieme', 250)->nullable();
            $table->string('sign_avence_apr_troisieme', 250)->nullable();
            $table->string('sg', 250)->nullable();
            $table->string('datesg', 250)->nullable();
            $table->string('fondboursser', 250)->nullable();
            $table->string('sign_fonddeboursse', 250)->nullable();
            $table->string('date_fonddeboursse', 250)->nullable();
            $table->string('fondresu', 250)->nullable();
            $table->string('signature_fondresu', 250)->nullable();
            $table->string('date_fondrecu', 25)->nullable();
            $table->string('userid', 15)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('djas');
    }
};
