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
        Schema::create('typevehicules', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 1000)->nullable();
            $table->string('userid', 1000)->nullable();
            $table->string('statut', 50)->default('Activé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typevehicules');
    }
};
