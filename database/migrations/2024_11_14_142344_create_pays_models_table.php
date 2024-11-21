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
        Schema::create('pays_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // BIGINT for user_id
            $table->string('name');
            $table->string('currenty_code');
            $table->string('phone_code');
            $table->string('status')->default('0');
            $table->timestamps();

            // Optionally, add a foreign key constraint if user_id references the id column in the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays_models');
    }
};
