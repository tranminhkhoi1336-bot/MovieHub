
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowtimesTable extends Migration
{
    public function up()
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('movie_id');
            $table->dateTime('starts_at');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('total_seats')->default(50);
            $table->string('status')->default('scheduled');

            $table->timestamps();

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('showtimes');
    }
}
