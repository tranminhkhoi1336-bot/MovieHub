
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPaymentVerificationToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_status', 20)
                ->default('unpaid');

            $table->string('payment_reference', 100)
                ->nullable()
                ->unique();

            $table->timestamp('payment_verified_at')
                ->nullable();

            $table->unsignedBigInteger('payment_verified_by')
                ->nullable();
        });

        // Don da xac nhan tu phien ban cu:
        // giu nguyen ve, khong mac dinh la da thanh toan.
        DB::table('bookings')
            ->where('status', 'confirmed')
            ->update([
                'payment_status' => 'legacy'
            ]);
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique(
                'bookings_payment_reference_unique'
            );

            $table->dropColumn([
                'payment_status',
                'payment_reference',
                'payment_verified_at',
                'payment_verified_by'
            ]);
        });
    }
}

