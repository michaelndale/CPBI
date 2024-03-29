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
        Schema::create('daps', function (Blueprint $table) {
            $table->id();
            $table->string('composantprojet', 1000)->nullable();
            $table->string('lieu', 1000)->nullable();
            $table->string('activiteiddap', 1000)->nullable();
            $table->string('referencefeb', 1000)->nullable();
            $table->string('etabliepar', 1000)->nullable();
            $table->string('lignebud', 1000)->nullable();
            $table->string('tauxex', 1000)->nullable();
            $table->string('comptebancaire', 1000)->nullable();
            $table->string('soldecomptable', 1000)->nullable();
            $table->string('montant', 1000)->nullable();
            $table->string('oud', 1000)->nullable();
            $table->string('cho', 1000)->nullable();
            $table->string('serviceid', 1000)->nullable();
            $table->string('userid', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daps');
    }
};
