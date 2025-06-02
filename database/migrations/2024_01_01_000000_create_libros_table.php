<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('edition');
            $table->year('copyright');
            $table->string('language');
            $table->integer('pages');
            $table->foreignId('autor_id')->constrained('autors')->onDelete('cascade');
            $table->foreignId('editorial_id')->constrained('editorials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
