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
        Schema::create('elementdjas', function (Blueprint $table) {
            $table->id();
            $table->string('febid')->nullable();
            $table->string('iddjas')->nullable();
            $table->string('idddap')->nullable();
            $table->string('ligneid')->nullable();
            $table->double('montant_avance')->nullable();
            $table->double('montant_utiliser')->nullable();
            $table->double('surplus')->nullable();
            $table->double('montant_retourne')->nullable();
            $table->string('bordereau')->nullable();
            $table->string('description')->nullable();
            $table->string('plaque')->nullable(); // Peut-être nullable si ce champ n'est pas toujours rempli
            $table->string('receptionpar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementdjas');
    }
};
