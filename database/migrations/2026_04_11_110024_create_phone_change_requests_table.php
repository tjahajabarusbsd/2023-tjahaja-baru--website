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
        Schema::create('phone_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_public_id')
                ->constrained('user_publics')
                ->cascadeOnDelete();
            $table->string('new_phone_number');
            $table->string('otp')->nullable();             // disimpan dalam bentuk hash
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamp('last_otp_sent_at')->nullable();
            $table->enum('status', ['pending', 'verified', 'expired'])->default('pending');
            $table->timestamps();

            // Satu user hanya boleh punya satu request aktif sekaligus
            $table->unique('user_public_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_change_requests');
    }
};
