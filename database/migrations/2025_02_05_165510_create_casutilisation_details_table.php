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
        Schema::create('casutilisation_details', function (Blueprint $table) {
            $table->id();
            $table->string('febid', 15)->nullable();
            $table->string('projetid', 15)->nullable();
            $table->string('exerciceid', 15)->nullable();
            $table->string('activiteid', 15)->nullable();
            $table->string('libelle', 225)->nullable();
            $table->string('unite', 100)->nullable();
            $table->string('quantity', 225)->nullable();
            $table->string('frequency', 225)->nullable();
            $table->string('unit_price', 225)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casutilisation_details');
    }
};
