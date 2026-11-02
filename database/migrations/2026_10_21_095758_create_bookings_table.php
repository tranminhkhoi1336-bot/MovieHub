
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('showtime_id');
            $table->unsignedInteger('quantity');
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('pending');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreign('showtime_id')
                ->references('id')
                ->on('showtimes')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
