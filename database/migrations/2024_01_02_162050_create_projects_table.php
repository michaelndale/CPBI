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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 1000)->nullable();
            $table->string('task', 1000)->nullable();
            $table->string('lead', 1000)->nullable();
            $table->string('start_date', 1000)->nullable();
            $table->string('deadline', 1000)->nullable();
            $table->string('numerorapport', 1000)->nullable();
            $table->string('region', 1000)->nullable();
            $table->string('numerodossier', 1000)->nullable();
            $table->string('numeroprojet', 1000)->nullable();
            $table->string('lieuprojet', 1000)->nullable();
            $table->string('devise', 1000)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('budget', 1000)->nullable();
            $table->string('statut', 50)->default(0);
            $table->string('verification', 1)->nullable();
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
        Schema::dropIfExists('projects');
    }
};
