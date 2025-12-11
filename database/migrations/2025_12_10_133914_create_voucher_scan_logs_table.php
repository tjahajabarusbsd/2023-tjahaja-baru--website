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
        Schema::create('voucher_scan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_claim_id')
                ->constrained('reward_claims')
                ->onDelete('cascade');
            $table->foreignId('scanned_by_merchant_id')
                ->constrained('merchants')
                ->onDelete('cascade');
            $table->string('result_status')->nullable();
            $table->timestamp('scan_time')->nullable();
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
        Schema::dropIfExists('voucher_scan_logs');
    }
};
