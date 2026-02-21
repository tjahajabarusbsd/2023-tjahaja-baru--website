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
        Schema::table('qr_scan_logs', function (Blueprint $table) {
            $table->unique(['user_public_id', 'qrcode_id'], 'unique_user_qrcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qr_scan_logs', function (Blueprint $table) {
            $table->dropUnique('unique_user_qrcode');
        });
    }
};
