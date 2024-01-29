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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100)->nullable();
            $table->string('prenom', 100)->nullable();
            $table->string('sexe', 25)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('statut', 50)->default('Activé');
            $table->string('avatar', 1000)->default('profile/avatar.png');
            $table->timestamp('dateemboche')->nullable();
            $table->string('phone', 25)->default(0);
            $table->string('fonction', 250)->default(0);
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
        Schema::dropIfExists('personnels');
    }
};
