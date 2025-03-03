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
        Schema::create('projet_acces_bailleurs', function (Blueprint $table) {
            $table->id();
            $table->string('verification_code', 6)->unique()->nullable();
            $table->string('qr_code')->nullable();
            $table->boolean('is_verified')->default(false); 
            $table->unsignedBigInteger('bailleurs_id'); 
            $table->foreign('bailleurs_id')->references('id')->on('bailleurs_de_fonds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projet_acces_bailleurs');
    }
};
