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
        Schema::create('febpetitcaisses', function (Blueprint $table) {
            $table->id();
            $table->integer('projet_id')->nullable();
            $table->integer('compte_id')->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('numero')->nullable();
            $table->double('montant')->nullable();
            $table->string('date_dossier', 25)->nullable();
            $table->string('date_limite', 25)->nullable();
        
            $table->integer('etabli_par')->nullable();
            $table->integer('verifie_par')->nullable();
            $table->integer('approuve_par')->nullable();
        
            $table->tinyInteger('etabli_par_signature')->default(0);
            $table->tinyInteger('verifie_par_signature')->default(0);
            $table->tinyInteger('approuve_par_signature')->default(0);
        
            $table->tinyInteger('signale')->default(0);
        
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('febpetitcaisses');
    }
};
