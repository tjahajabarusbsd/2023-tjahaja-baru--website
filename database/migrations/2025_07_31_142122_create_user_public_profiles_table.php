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
        Schema::create('user_public_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_public_id')->unique();
            $table->date('tgl_lahir');
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan');
            $table->string('total_points')->default('0');
            $table->string('foto_profil')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_kk')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('user_public_profiles');
    }
};
