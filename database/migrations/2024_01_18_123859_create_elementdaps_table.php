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
        Schema::create('elementdaps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dapid');
            $table->foreign('dapid')->references('id')->on('daps');
            $table->string('libelle', 1000)->nullable();
            $table->double('montant', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementdaps');
    }
};
