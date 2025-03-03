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
        Schema::create('comptepetitecaisses', function (Blueprint $table) {
            $table->id();
            $table->integer('projetid')->nullable();
            $table->integer('exercice_id')->nullable();
            $table->string('libelle', 225)->nullable();
            $table->string('code', 225)->nullable();
            $table->double('solde', 25)->nullable();
            $table->integer('userid')->nullable();
            $table->string('close', 225)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptepetitecaisses');
    }
};
