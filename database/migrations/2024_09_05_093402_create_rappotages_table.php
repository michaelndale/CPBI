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
        Schema::create('rappotages', function (Blueprint $table) {
            $table->id();
            $table->string('dernier_solde')->nullable();
            $table->string('verifier_par', 2)->default(0);
            $table->string('approver_par', 2)->default(0);
            $table->string('verifier_signature', 2)->default(0);
            $table->string('approver_signature', 2)->default(0);
            $table->string('numero_groupe')->nullable();
            $table->string('userid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rappotages');
    }
};
