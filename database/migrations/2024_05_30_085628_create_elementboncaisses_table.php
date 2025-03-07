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
        Schema::create('elementboncaisses', function (Blueprint $table) {
            $table->id();
            $table->integer('projetid')->nullable();
            $table->integer('exerciceid')->nullable();
            $table->date('boncaisse_id')->nullable();  // Assuming date is a date field
            
            $table->text('ligneid')->nullable();
            $table->text('ligne_principale')->nullable();
            $table->text('montant')->nullable();

            $table->text('motifs')->nullable();
            $table->text('input')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementboncaisses');
    }
};
