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
        Schema::create('dapbpcs', function (Blueprint $table) {
            $table->id();

          //  $table->string('referencefeb', 11)->nullable();
          //  $table->string('numerocheck', 225)->nullable();

            $table->string('serviceid', 11)->nullable();
            $table->string('projetid', 11)->nullable();
            $table->string('exercice_id', 11)->nullable();
            $table->string('numerodap', 11)->nullable();
            $table->string('lieu', 100)->nullable();
            $table->string('comptebanque', 225)->nullable();
            $table->string('ov', 225)->nullable();
            $table->string('cho', 225)->nullable();

            $table->string('demande_etablie', 11)->nullable();
            $table->string('verifier', 11)->nullable();
            $table->string('approuver', 11)->nullable();
            $table->string('autoriser', 11)->nullable();
            $table->string('secretaire', 11)->nullable();
            $table->string('chefprogramme', 11)->nullable();
            $table->string('etablie_aunom', 11)->nullable();
           
            $table->string('banque', 30)->nullable();
            $table->string('beneficiaire', 225)->nullable();
            $table->string('justifier', 11)->nullable();
            $table->string('nonjustifier', 11)->nullable();

            $table->string('demande_etablie_signe', 11)->default(0);
            $table->string('verifier_signe', 11)->default(0);
            $table->string('approuver_signe', 11)->default(0);
            $table->string('autoriser_signe', 11)->default(0);
            $table->string('chefprogramme_signe', 11)->default(0);
            $table->string('secretaire_signe', 11)->default(0);


            $table->string('demande_etablie_date', 25)->nullable();
            $table->string('verifier_date', 25)->nullable();
            $table->string('approuver_date', 25)->nullable();
             $table->string('dateautorisation', 25)->nullable();
            $table->string('userid', 1000)->nullable();

            $table->string('observation', 1000)->nullable();

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dapbpcs');
    }
};
