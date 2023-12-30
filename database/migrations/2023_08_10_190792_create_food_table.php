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
        Schema::create('food', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');

            $table->string('name');
            $table->string('description');
            $table->integer('price');
            $table->integer('timeView');
            $table->integer('freeze')->default(0);
            $table->integer('position');
            $table->string('file');
            $table->string('info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
