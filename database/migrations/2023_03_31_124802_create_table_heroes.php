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
        Schema::create('table_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('power-level');
            $table->date('birthday');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('table_heroes_language', function (Blueprint $table) {
            $table->id();

            $table->integer("hero_id");
            $table->string("language");

            $table->text('description');
            $table->json('skills');
            $table->string('race');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_heroes');
    }
};