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
        Schema::create('entretien_programmers', function (Blueprint $table) {
            $table->id();
            $table->string('entretien_id');
            $table->string('type_entretien');
            $table->string('date_prevue');
            $table->string('descruption_pe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entretien_programmers');
    }
};
