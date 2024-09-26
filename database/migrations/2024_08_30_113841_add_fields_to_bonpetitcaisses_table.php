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
            $table->string('etabli_par')->nullable();
        $table->string('verifie_par')->nullable();
        $table->string('approuve_par')->nullable();
        $table->string('etabli_par_signature')->nullable();
        $table->string('verifie_par_signature')->nullable();
        $table->string('approuve_par_signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bonpetitcaisses', function (Blueprint $table) {
            $table->dropColumn('etabli_par');
            $table->dropColumn('verifie_par');
            $table->dropColumn('approuve_par');
            $table->dropColumn('etabli_par_signature');
            $table->dropColumn('verifie_par_signature');
            $table->dropColumn('approuve_par_signature');
        });
    }
};
