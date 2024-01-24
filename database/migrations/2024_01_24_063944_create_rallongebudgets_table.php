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
            $table->unsignedBigInteger('projetid');
            $table->foreign('projetid')->references('id')->on('projects');
            $table->unsignedBigInteger('compteid');
            $table->foreign('compteid')->references('id')->on('comptes');
            $table->string('depensecumule', 1000)->nullable();
            $table->string('budgetactuel', 1000)->nullable();
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
        Schema::dropIfExists('rallongebudgets');
    }
};
