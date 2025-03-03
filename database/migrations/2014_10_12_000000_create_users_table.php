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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('personnelid', 100)->nullable();
            $table->string('identifiant', 100)->nullable();
            $table->string('statut', 10)->default('Activé');
            $table->string('password');
            $table->string('avatar', 1000)->default('element/profile/default.png');
            $table->string('signature', 1000)->default('element/signature/signature.jpg');
            $table->string('role', 50)->default(0);
            $table->string('userid', 50)->default(0);
            $table->timestamp('last_activity')->nullable();
            $table->boolean('is_connected')->default(false); // False par défaut pour les utilisateurs non connectés
            $table->string('email')->nullable();
            $table->string('verification_code', 6)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
