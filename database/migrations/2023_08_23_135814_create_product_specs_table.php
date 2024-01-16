<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('p_l_t')->nullable();
            $table->string('jarak_sumbu_roda')->nullable();
            $table->string('ground_clearence')->nullable();
            $table->string('tinggi_tempat_duduk')->nullable();
            $table->string('berat_isi')->nullable();
            $table->string('volume_tangki')->nullable();
            $table->string('volume_bagasi')->nullable();
            $table->string('tipe_rangka')->nullable();
            $table->string('suspensi_depan')->nullable();
            $table->string('suspensi_belakang')->nullable();
            $table->string('tipe_ban')->nullable();
            $table->string('ban_depan')->nullable();
            $table->string('ban_belakang')->nullable();
            $table->string('rem_depan')->nullable();
            $table->string('rem_belakang')->nullable();
            $table->string('rem_abs')->nullable();
            $table->string('kapasitas')->nullable();
            $table->string('pendingin')->nullable();
            $table->string('d_x_l')->nullable();
            $table->string('rasio_kompresi')->nullable();
            $table->string('daya_maksimum')->nullable();
            $table->string('torsi_maksimum')->nullable();
            $table->string('sistem_starter')->nullable();
            $table->string('kapasitas_oli_mesin')->nullable();
            $table->string('sistem_bbm')->nullable();
            $table->string('tipe_kopling')->nullable();
            $table->string('tipe_transmisi')->nullable();
            $table->string('sistem_pengapian')->nullable();
            $table->string('baterai')->nullable();
            $table->string('busi')->nullable();
            $table->string('price')->nullable();
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
        Schema::dropIfExists('product_specs');
    }
}
