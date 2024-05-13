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
        Schema::create('pleincarburants', function (Blueprint $table) {
            $table->id();
            $table->string('referenceblaque', 35)->nullable();
            $table->string('fournisseurid', 35)->nullable();
            $table->string('carburent', 225)->nullable();
            $table->double('quantite', 25)->nullable();
            $table->double('prixunite', 25)->nullable();
            $table->double('kilometragedebut', 25)->nullable();
            $table->double('kilometragefin', 25)->nullable();
            $table->longText('note')->nullable();
            $table->integer('userid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pleincarburants');
    }
};
