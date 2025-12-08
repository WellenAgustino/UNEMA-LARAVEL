<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->date('show_date');
            $table->time('show_time');
            $table->string('studio');
            $table->decimal('price', 10, 2);
            $table->integer('available_seats')->default(0);
            $table->integer('total_seats')->default(50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('showtimes');
    }
};