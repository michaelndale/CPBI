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
        Schema::table('projet_acces_bailleurs', function (Blueprint $table) {
            $table->unsignedBigInteger('projet_id')->after('bailleurs_id'); // Ajoute la colonne projet_id
            $table->foreign('projet_id')->references('id')->on('projects')->onDelete('cascade'); // Clé étrangère
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projet_acces_bailleurs', function (Blueprint $table) {
            $table->dropForeign(['projet_id']); // Supprime la contrainte
            $table->dropColumn('projet_id'); // Supprime la colonne
        });
    }
};
