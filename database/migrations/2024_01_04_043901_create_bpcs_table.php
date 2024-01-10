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
        Schema::create('bpcs', function (Blueprint $table) {

            $table->id();
            $table->string('titre', 1000)->nullable();
            $table->string('sousigne', 1000)->nullable();
            $table->string('typecarte', 1000)->nullable();
            $table->string('numeropiece', 1000)->nullable();
            $table->string('adresse', 1000)->nullable();
            $table->string('telephone', 1000)->nullable();
            $table->string('recumontant', 1000)->nullable();
            $table->string('text_montantrecu', 1000)->nullable();
            $table->string('motif', 1000)->nullable();
            $table->string('faita', 1000)->nullable();
            $table->string('datedoc', 1000)->nullable();
            $table->string('beneficiaire', 1000)->nullable();
            $table->string('signature', 1000)->nullable();
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
        Schema::dropIfExists('bpcs');
    }
};
