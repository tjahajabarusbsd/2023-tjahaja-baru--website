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
        Schema::table('nomor_rangkas', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('user_id');
            $table->string('ktp')->nullable()->after('phone_number');
            $table->string('kk')->nullable()->after('ktp');
            $table->string('nama_model')->nullable()->after('kk');
            $table->string('nomor_plat')->nullable()->after('nama_model');
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending')->after('nomor_plat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomor_rangkas', function (Blueprint $table) {
            //
        });
    }
};
