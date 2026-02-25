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
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->string('jenis_kerjasama')->after('benefit');
            $table->decimal('tb_percentage', 5, 2)->nullable()->after('jenis_kerjasama');
            $table->decimal('merchant_percentage', 5, 2)->nullable()->after('tb_percentage');
            $table->decimal('nominal', 12, 2)->nullable()->after('merchant_percentage');

            $table->string('tipe_hadiah')->nullable()->after('nominal');
            $table->string('tipe_qr')->nullable()->after('tipe_hadiah');

            $table->string('redirect_url')->nullable()->after('tipe_qr');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qrcodes', function (Blueprint $table) {
            $table->dropColumn('jenis_kerjasama');
            $table->dropColumn('tb_percentage');
            $table->dropColumn('merchant_percentage');
            $table->dropColumn('nominal');
            $table->dropColumn('tipe_hadiah');
            $table->dropColumn('tipe_qr');
            $table->dropColumn('redirect_url');
        });
    }
};
