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
        Schema::create('lettreexpedictions', function (Blueprint $table) {
            $table->id();
            $table->string('classeurid', 1000)->nullable();
            $table->string('numerogenerale', 1000)->nullable();
            $table->string('numeolettre', 1000)->nullable();
            $table->date('datelettre');
            $table->date('dateexpedition');
            $table->string('destinateur', 250)->nullable();
            $table->string('note', 1000)->nullable();
            $table->string('statut', 25)->default('Activé');
            $table->string('userid', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lettreexpedictions');
    }
};
