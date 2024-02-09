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
        Schema::create('elementdaps', function (Blueprint $table) {
            $table->id();
            $table->string('dapid', 1000)->nullable();
            $table->string('libelle', 1000)->nullable();
            $table->string('montant', 25)->nullable();
            $table->string('statut', 10)->default('Activé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementdaps');
    }
};
