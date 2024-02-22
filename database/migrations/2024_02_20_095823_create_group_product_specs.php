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
        Schema::create('group_product_specs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->string('tipe_mesin')->nullable();
            $table->string('jumlah_silinder')->nullable();
            $table->string('volume_silinder')->nullable();
            $table->string('diameter_x_langkah')->nullable();
            $table->string('perbandingan_kompresi')->nullable();
            $table->string('daya_maksimum')->nullable();
            $table->string('torsi_maksimum')->nullable();
            $table->string('sistem_starter')->nullable();
            $table->string('sistem_pelumasan')->nullable();
            $table->string('kapasitas_oli')->nullable();
            $table->string('sistem_bahan_bakar')->nullable();
            $table->string('tipe_kopling')->nullable();
            $table->string('tipe_transmisi')->nullable();
            $table->string('pola_transmisi')->nullable();
            $table->string('tipe_rangka')->nullable();
            $table->string('suspensi_depan')->nullable();
            $table->string('suspensi_belakang')->nullable();
            $table->string('tipe_ban')->nullable();
            $table->string('ban_depan')->nullable();
            $table->string('ban_belakang')->nullable();
            $table->string('rem_depan')->nullable();
            $table->string('rem_belakang')->nullable();
            $table->string('p_l_t')->nullable();
            $table->string('jarak_sumbu')->nullable();
            $table->string('jarak_terendah_ketanah')->nullable();
            $table->string('tinggi_tempat_duduk')->nullable();
            $table->string('berat_isi')->nullable();
            $table->string('kapasitas_tangki')->nullable();
            $table->string('sistem_pengapian')->nullable();
            $table->string('battery')->nullable();
            $table->string('tipe_busi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_product_specs');
    }
};
