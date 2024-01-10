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
        Schema::create('djas', function (Blueprint $table) {
            $table->id();
            $table->string('numerodjas', 1000)->nullable();
            $table->string('fournisseurid', 1000)->nullable();
            $table->string('motif', 1000)->nullable();
            $table->string('fondrecu_date', 1000)->nullable();
            $table->string('numerofeb', 1000)->nullable();
            $table->string('numerodap', 1000)->nullable();
            $table->string('numeroov', 1000)->nullable();
            $table->string('lignebdt', 1000)->nullable();
            $table->string('montant_avance', 1000)->nullable();
            $table->string('devise', 1000)->nullable();
            $table->string('duree_avence', 1000)->nullable();
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('djas');
    }
};
