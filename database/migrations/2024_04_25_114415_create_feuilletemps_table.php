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
        Schema::create('feuilletemps', function (Blueprint $table) {
            $table->id();
            $table->integer('userid')->nullable();
            $table->integer('superviseur')->nullable();
            $table->integer('projetid')->nullable();
            $table->string('description', 1000)->nullable();
            $table->integer('nombre')->nullable();
            $table->string('realisation')->nullable();
            $table->string('iov')->nullable();
            $table->string('heuredepart')->nullable();
            $table->string('heurearrive')->nullable();
            $table->string('resultat')->nullable();
            $table->string('observation',1000)->nullable();
            $table->date('datepresence')->nullable();
            $table->integer('tempstotal')->nullable();
            $table->integer('tempsmoyennne')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feuilletemps');
    }
};
