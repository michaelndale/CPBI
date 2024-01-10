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
            $table->string('name', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('role', 100)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('statut', 50)->default(0);
            $table->string('avatar', 1000)->default('profile/avatar.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('departement', 150)->default(0);
            $table->string('phone', 25)->default(0);
            $table->string('fonction', 250)->default(0);
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users');
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
