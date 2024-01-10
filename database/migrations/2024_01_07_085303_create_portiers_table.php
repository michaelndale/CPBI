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
        Schema::create('portiers', function (Blueprint $table) {
            $table->id();
            $table->string('datep', 1000)->nullable();
            $table->string('objectp', 1000)->nullable();
            $table->string('utineraire', 1000)->nullable();
            $table->string('heuredepart', 1000)->nullable();
            $table->string('heurearrive', 1000)->nullable();
            $table->string('chauffeur', 1000)->nullable();
            $table->string('chefmission', 1000)->nullable();
            $table->string('signature', 1000)->nullable();
            $table->string('blaque', 1000)->nullable();
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
        Schema::dropIfExists('portiers');
    }
};
