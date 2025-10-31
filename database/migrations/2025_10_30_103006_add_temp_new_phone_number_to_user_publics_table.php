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
        Schema::table('user_publics', function (Blueprint $table) {
            $table->string('temp_new_phone_number')
                ->nullable()
                ->after('phone_number')
                ->comment('Nomor HP baru sementara untuk verifikasi OTP sebelum diset permanen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_publics', function (Blueprint $table) {
            $table->dropColumn('temp_new_phone_number');
        });
    }
};
