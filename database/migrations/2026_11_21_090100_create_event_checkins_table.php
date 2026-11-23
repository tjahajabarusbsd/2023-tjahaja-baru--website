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
        Schema::create('event_checkins', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_public_id');

            // Tiket yang ditampilkan ke user setelah check-in
            $table->string('checkin_code', 20)->unique();

            $table->timestamp('checked_in_at')->useCurrent();

            $table->timestamps();

            // Satu akun hanya boleh check-in sekali per event
            $table->unique(['event_id', 'user_public_id']);

            $table->index('user_public_id');
            $table->index(['event_id', 'checked_in_at']);

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

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
        Schema::dropIfExists('event_checkins');
    }
};
