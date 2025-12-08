<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->integer('duration')->nullable();
            $table->decimal('rating', 2, 1)->nullable();
            $table->date('release_date')->nullable();
            $table->string('genre')->nullable();
            $table->enum('status', ['now_showing', 'coming_soon'])->default('now_showing');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
};