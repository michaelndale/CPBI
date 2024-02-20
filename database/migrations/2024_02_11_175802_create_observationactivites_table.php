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
        Schema::create('observationactivites', function (Blueprint $table) {
            $table->id();
            $table->string('projetid', 1000)->nullable();
            $table->string('userid', 1000)->nullable();
            $table->string('activiteid', 1000)->nullable();
            $table->string('message', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observationactivites');
    }
};
