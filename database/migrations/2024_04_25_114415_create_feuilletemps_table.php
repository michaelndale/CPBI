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
        Schema::create('feuilletemps', function (Blueprint $table) {
            $table->id();
            $table->integer('userid')->nullable();
            $table->integer('superviseur')->nullable();
            $table->integer('projetid')->nullable();
            $table->date('datepresence')->nullable();
            $table->integer('nombre')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feuilletemps');
    }
};
