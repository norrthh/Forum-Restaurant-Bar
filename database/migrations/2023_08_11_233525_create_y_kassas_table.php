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
        Schema::create('y_kassas', function (Blueprint $table) {
            $table->id();
            $table->string('sign');
            $table->ipAddress('ip_address');
            $table->json('foods');
            $table->string('phone');
            $table->integer('numberApp');
            $table->integer('typeApp');
            $table->integer('price');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('y_kassas');
    }
};
