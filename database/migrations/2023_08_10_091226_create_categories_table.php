<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->timestamps();
        });

        $categories = [
            'Закуски',
            'Салаты',
            'Супы',
            'Основные блюда',
            'Гриль',
            'Гарниры',
            'Десерты',
            'Безалкогольные напитки',
            'Алкогольные напитки'
        ];



        foreach ($categories as $key => $category) {
            \App\Models\Category::query()->create([
                'name' => $category,
                'image' => '/image/'. $key . '.jpg'
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
