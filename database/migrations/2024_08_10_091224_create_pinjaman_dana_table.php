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
        Schema::create('pinjaman_dana', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->unsignedBigInteger('nohp');
            $table->string('tipe');
            $table->string('tipe_lain')->nullable();
            $table->integer('tahun');
            $table->decimal('estimasi_harga', 15, 2); // Precision 15, scale 2
            $table->decimal('want_dana', 15, 2); 
            $table->integer('tenor');
            $table->decimal('estimasi_angsuran', 15, 2); 
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('set null'); // Foreign key to 'users' table
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
        Schema::dropIfExists('pinjaman_dana');
    }
};
