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
        Schema::create('projet_bailleurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // BIGINT for user_id
            $table->unsignedBigInteger('projet_id'); // BIGINT for user_id
            $table->unsignedBigInteger('bailleurs_id'); // BIGINT for user_id
            $table->decimal('montant_alloue', 15, 2); // Montant alloué au projet
            $table->enum('type_financement', ['subvention', 'prêt', 'investissement']); // Type de financement
            $table->date('debut_financement'); // Date de début du financement
            $table->date('fin_financement'); // Date de fin du financement
            $table->text('objectifs')->nullable(); // Objectifs du financement
            $table->text('conditions')->nullable(); // Conditions particulières pour l’utilisation des fonds
            $table->timestamps();

            // Optionally, add a foreign key constraint if user_id references the id column in the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('projet_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('bailleurs_id')->references('id')->on('bailleurs_de_fonds')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projet_bailleurs');
    }
};
