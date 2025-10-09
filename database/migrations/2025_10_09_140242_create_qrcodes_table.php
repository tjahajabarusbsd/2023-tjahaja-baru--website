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
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_qrcode');
            $table->string('kode')->unique();
            $table->integer('poin');
            $table->dateTime('masa_berlaku_mulai');
            $table->dateTime('masa_berlaku_selesai');
            $table->boolean('aktif')->default(true);
            $table->integer('max_penggunaan')->nullable();
            $table->integer('jumlah_penggunaan')->default(0);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // Soft delete

            // Index untuk performa
            $table->index('kode');
            $table->index('aktif');
            $table->index('masa_berlaku_selesai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qrcodes');
    }
};
