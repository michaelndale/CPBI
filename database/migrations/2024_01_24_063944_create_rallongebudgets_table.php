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
        Schema::create('rallongebudgets', function (Blueprint $table) {
            $table->id();
            $table->string('projetid', 1000)->nullable();
            $table->string('compteid', 1000)->nullable();
            $table->string('budgetactuel', 1000)->nullable();
            $table->string('userid', 1000)->nullable();
            $table->string('statut', 10)->default('Activé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rallongebudgets');
    }
};
