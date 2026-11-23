<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('checkin_enabled')->default(false)->after('is_active');
            $table->string('checkin_token', 64)->nullable()->unique()->after('checkin_enabled');
            $table->dateTime('checkin_open_at')->nullable()->after('checkin_token');
            $table->dateTime('checkin_close_at')->nullable()->after('checkin_open_at');
            $table->string('location')->nullable()->after('checkin_close_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropUnique(['checkin_token']);
            $table->dropColumn([
                'checkin_enabled',
                'checkin_token',
                'checkin_open_at',
                'checkin_close_at',
                'location',
            ]);
        });
    }
};
