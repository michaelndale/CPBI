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
        Schema::create('bonpetitcaisses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid')->nullable();  // Assuming userid is a foreign key
            $table->date('date')->nullable();  // Assuming date is a date field
            $table->text('motif')->nullable();
            $table->string('nom_prenom_sous_signe')->nullable();  // Assuming this is a name field
            $table->integer('beneficiaire')->nullable();
            $table->boolean('signe_beneficiaire')->default(0);
            $table->integer('distributaire')->nullable();
            $table->boolean('signe_distributaire')->default(0);
            $table->integer('approbation')->nullable();
            $table->boolean('signe_approbation')->default(0);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonpetitcaisses');
    }
};
