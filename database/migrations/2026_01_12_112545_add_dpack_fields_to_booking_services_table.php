<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_services', function (Blueprint $table) {
            $table->uuid('service_schedule_id')
                ->nullable()
                ->after('jam');

            $table->uuid('serialized_product_id')
                ->nullable()
                ->after('service_schedule_id');

            $table->string('external_status', 50)
                ->nullable()
                ->after('serialized_product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_services', function (Blueprint $table) {
            $table->dropColumn([
                'service_schedule_id',
                'serialized_product_id',
                'external_status',
            ]);
        });
    }
};
