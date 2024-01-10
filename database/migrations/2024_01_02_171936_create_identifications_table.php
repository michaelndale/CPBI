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
        Schema::create('identifications', function (Blueprint $table) {
            $table->id();
            $table->string('nominstitution', 1000)->nullable();
            $table->string('nif', 1000)->nullable();
            $table->string('adresse', 1000)->nullable();
            $table->string('email', 1000)->nullable();
            $table->string('phone', 1000)->nullable();
            $table->string('bp', 1000)->nullable();
            $table->string('fax', 1000)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('urlogo', 1000)->nullable();
            $table->string('statut', 50)->default(0);
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
        Schema::dropIfExists('identifications');
    }
};
