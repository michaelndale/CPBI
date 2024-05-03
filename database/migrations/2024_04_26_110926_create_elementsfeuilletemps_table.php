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
        Schema::create('elementsfeuilletemps', function (Blueprint $table) {
            $table->id();
            $table->integer('userid')->nullable();
            $table->integer('tempstotal')->nullable();
            $table->integer('tempsmoyennne')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementsfeuilletemps');
    }
};
