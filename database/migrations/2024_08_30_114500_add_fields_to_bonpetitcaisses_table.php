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
        Schema::table('bonpetitcaisses', function (Blueprint $table) {
            $table->string('nom_sousigne')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bonpetitcaisses', function (Blueprint $table) {
            $table->dropColumn('nom_sousigne');
        });
    }
};
