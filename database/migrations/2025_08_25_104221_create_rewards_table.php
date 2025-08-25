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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('image')->nullable();
            $table->integer('point');
            $table->integer('quantity')->default(0);
            $table->date('masa_berlaku_mulai')->nullable();
            $table->date('masa_berlaku_selesai')->nullable();
            $table->boolean('aktif')->default(true);
            $table->text('deskripsi')->nullable();
            $table->text('terms_conditions')->nullable();
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
        Schema::dropIfExists('rewards');
    }
};
