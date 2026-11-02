
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiresAtToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->timestamp('expires_at')->nullable();

            $table->index(
                ['status', 'expires_at'],
                'bookings_status_expires_at_index'
            );

        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropIndex(
                'bookings_status_expires_at_index'
            );

            $table->dropColumn('expires_at');

        });
    }
}
