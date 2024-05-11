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
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->string('fournisseurid', 1000)->nullable();
            $table->string('constructeur', 1000)->nullable();
            $table->string('numero', 1000)->nullable();
            $table->double('prix', 1000)->nullable();
            $table->string('dateprix', 1000)->nullable();
            $table->integer('userid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
