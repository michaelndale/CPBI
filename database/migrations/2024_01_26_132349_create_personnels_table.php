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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100)->nullable();
            $table->string('prenom', 100)->nullable();
            $table->string('sexe', 25)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone', 15)->default(0);
            $table->string('fonction', 250)->nullable();
            $table->date('dateemboche')->nullable();
            $table->string('statut', 10)->default('Activé');
            $table->string('userid', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
