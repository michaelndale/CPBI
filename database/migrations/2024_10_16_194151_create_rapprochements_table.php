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
        Schema::create('rapprochements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projetid');
            $table->foreign('projetid')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('serviceid');
            $table->foreign('serviceid')->references('id')->on('services')->onDelete('cascade');
            $table->string('numero', 25);
            $table->date('datede');
            $table->date('dateau');
            $table->integer('etabliepar');
            $table->integer('verifier');
            $table->integer('signeetabliepar')->default(0);
            $table->integer('signeverifier')->default(0);
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapprochements');
    }
};
