
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tmdb_id')->nullable()->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('genre')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->date('release_date')->nullable();
            $table->string('poster')->nullable();
            $table->string('status')->default('coming_soon');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
