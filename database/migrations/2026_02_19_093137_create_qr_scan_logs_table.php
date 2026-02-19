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
        Schema::create('qr_scan_logs', function (Blueprint $table) {
            $table->id();

            $table->string('scan_code')->unique();

            $table->unsignedBigInteger('user_public_id');
            $table->unsignedBigInteger('qrcode_id');

            $table->integer('usage_count')->nullable();
            $table->integer('max_usage')->nullable();

            $table->timestamp('scanned_at')->useCurrent();

            $table->timestamps();

            // INDEX
            $table->index('user_public_id');
            $table->index('qrcode_id');

            // FOREIGN KEY
            $table->foreign('user_public_id')
                ->references('id')
                ->on('user_publics')
                ->onDelete('cascade');

            $table->foreign('qrcode_id')
                ->references('id')
                ->on('qrcodes')
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
        Schema::dropIfExists('qr_scan_logs');
    }
};
