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
        Schema::table('user_public_profiles', function (Blueprint $table) {
            // --- Langkah 1: Ubah tgl_lahir dan alamat menjadi nullable ---
            // Ini bisa dilakukan terlebih dahulu karena operasinya sederhana
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->date('tgl_lahir')->nullable()->change();
                $table->text('alamat')->nullable()->change();
            });

            // --- Langkah 2: Proses untuk mengganti enum jenis_kelamin menjadi string ---

            // 2a. Tambah kolom baru sementara bertipe string dan nullable
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->string('jenis_kelamin_new', 1)->nullable()->after('jenis_kelamin');
            });

            // 2b. Salin data dari kolom lama (enum) ke kolom baru (string)
            DB::table('user_public_profiles')->update([
                'jenis_kelamin_new' => DB::raw('jenis_kelamin')
            ]);

            // 2c. Hapus kolom lama (bertipe enum)
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->dropColumn('jenis_kelamin');
            });

            // 2d. Ubah nama kolom baru menjadi nama kolom lama
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->renameColumn('jenis_kelamin_new', 'jenis_kelamin');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_public_profiles', function (Blueprint $table) {
            // --- Proses Rollback ---

            // Langkah 1: Kembalikan perubahan jenis_kelamin dari string ke enum

            // 1a. Ubah nama kolom string kembali ke nama sementara
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->renameColumn('jenis_kelamin', 'jenis_kelamin_new');
            });

            // 1b. Tambah kembali kolom lama bertipe enum (NOT NULL, seperti aslinya)
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->enum('jenis_kelamin', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan')->after('jenis_kelamin_new');
            });

            // 1c. Salin data dari kolom string ke kolom enum
            DB::table('user_public_profiles')->update([
                'jenis_kelamin' => DB::raw('jenis_kelamin_new')
            ]);

            // 1d. Hapus kolom sementara (bertipe string)
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->dropColumn('jenis_kelamin_new');
            });

            // --- Langkah 2: Kembalikan tgl_lahir dan alamat menjadi NOT NULL ---
            Schema::table('user_public_profiles', function (Blueprint $table) {
                $table->date('tgl_lahir')->nullable(false)->change();
                $table->text('alamat')->nullable(false)->change();
            });
        });
    }
};
