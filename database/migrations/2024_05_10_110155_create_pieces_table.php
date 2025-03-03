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
            $table->string('fournisseurid', 11)->nullable();
            $table->string('nom', 225)->nullable();
            $table->string('constructeur', 100)->nullable();
            $table->string('numero', 25)->nullable();
            $table->double('prix', 30)->nullable();
            $table->string('dateprix', 15)->nullable();
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
