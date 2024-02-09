<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 1000)->nullable();
            $table->string('compteid', 1000)->nullable();
            $table->string('souscompteid', 1000)->nullable();
            $table->string('libelle', 1000)->nullable();
            $table->string('projetid', 1000)->nullable();
            $table->string('stat', 1000)->nullable();
            $table->string('userid', 1000)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};
