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
        Schema::create('realisationplans', function (Blueprint $table) {
            $table->id();
            $table->string('projeid', 11)->nullable();
            $table->string('planid', 11)->nullable();
            $table->string('activiteid', 11)->nullable();
            $table->string('nombrehomme', 11)->nullable();
            $table->string('nombrefemme', 11)->nullable();
            $table->string('nombreseance', 11)->nullable();
            $table->string('daterea', 11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisationplans');
    }
};
