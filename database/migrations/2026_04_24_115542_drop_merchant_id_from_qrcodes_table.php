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
            // Drop foreign key dulu
            $table->dropForeign(['merchant_id']);

            // Baru drop kolom
            $table->dropColumn('merchant_id');
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
            $table->unsignedBigInteger('merchant_id')
                ->nullable()
                ->after('id');

            $table->foreign('merchant_id')
                ->references('id')
                ->on('merchants')
                ->nullOnDelete();
        });
    }
};
