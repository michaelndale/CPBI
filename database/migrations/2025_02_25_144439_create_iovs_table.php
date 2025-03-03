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
        Schema::create('iovs', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255); // Correction de la longueur (255 au lieu de 225)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Nouvelle clé étrangère vers la table "users"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iovs');
    }
};
