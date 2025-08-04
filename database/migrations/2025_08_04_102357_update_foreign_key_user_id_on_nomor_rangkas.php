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
            // Rename kolom user_id menjadi user_public_id
            if (Schema::hasColumn('nomor_rangkas', 'user_id')) {
                $table->renameColumn('user_id', 'user_public_id');
            }
        });

        Schema::table('nomor_rangkas', function (Blueprint $table) {
            // Tambahkan foreign key baru ke tabel user_publics
            $table->foreign('user_public_id')
                ->references('id')
                ->on('user_publics')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback: Hapus foreign key dan rename kolom balik
        Schema::table('nomor_rangkas', function (Blueprint $table) {
            $table->dropForeign(['user_public_id']);
            $table->renameColumn('user_public_id', 'user_id');
        });

        Schema::table('nomor_rangkas', function (Blueprint $table) {
            // (Opsional) Tambahkan kembali foreign key lama jika perlu
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
