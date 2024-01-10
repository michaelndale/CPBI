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
        Schema::create('lettrerecuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classeurid');
            $table->foreign('classeurid')->references('id')->on('classeurs');
            $table->string('numerogenerale', 1000)->nullable();
            $table->string('numeolettre', 1000)->nullable();
            $table->date('datelettre');
            $table->date('datelerecu');
            $table->string('destinateur', 250)->nullable();
            $table->string('note', 1000)->nullable();
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
        Schema::dropIfExists('lettrerecuses');
    }
};
