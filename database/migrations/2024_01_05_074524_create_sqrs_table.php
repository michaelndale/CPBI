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
        Schema::create('sqrs', function (Blueprint $table) {
            $table->id();
            $table->string('datesqr', 1000)->nullable();
            $table->string('employe', 1000)->nullable();
            $table->string('lieu', 1000)->nullable();
            $table->string('activiteref', 1000)->nullable();
            $table->string('datesq', 1000)->nullable();
            $table->string('oe', 1000)->nullable();
            $table->string('op', 1000)->nullable();
            $table->string('non', 1000)->nullable();
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
        Schema::dropIfExists('sqrs');
    }
};
