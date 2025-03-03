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
        Schema::create('annexe_utilisations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('djasid');
            $table->foreign('djasid')->references('id')->on('djas')->onDelete('cascade');
            $table->unsignedBigInteger('annexid');
            $table->foreign('annexid')->references('id')->on('apreviations')->onDelete('cascade');
            $table->string('urldoc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annexe_utilisations');
    }
};
