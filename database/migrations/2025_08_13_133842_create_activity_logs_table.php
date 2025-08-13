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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_public_id');

            // polymorphic relation
            $table->string('source_type');
            $table->unsignedBigInteger('source_id');

            $table->string('type'); // redeem, referral, scan, booking, dll
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('points')->default(0); // positif = tambah poin, negatif = kurangi poin
            $table->timestamp('activity_date')->useCurrent();
            $table->timestamps();

            // foreign key ke user_publics
            $table->foreign('user_public_id')
                ->references('id')
                ->on('user_publics')
                ->onDelete('cascade');

            // index untuk mempercepat query polymorphic
            $table->index(['source_type', 'source_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
