<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsBookingServiceAvailableToDealersTable extends Migration
{
    public function up()
    {
        Schema::table('dealers', function (Blueprint $table) {
            $table->boolean('is_booking_service_available')
                ->default(false)
                ->after('longitude');
        });
    }

    public function down()
    {
        Schema::table('dealers', function (Blueprint $table) {
            $table->dropColumn('is_booking_service_available');
        });
    }
}
