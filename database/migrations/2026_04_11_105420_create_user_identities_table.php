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
        Schema::create('user_identities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_public_id')
                ->constrained('user_publics')
                ->cascadeOnDelete();
            $table->enum('provider', ['phone', 'google', 'facebook']);
            $table->string('provider_id'); // nomor HP / google sub / facebook id
            $table->timestamps();

            // Satu provider_id hanya boleh terdaftar satu kali per provider
            $table->unique(['provider', 'provider_id']);

            // Satu user hanya boleh punya satu identity per provider
            $table->unique(['user_public_id', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_identities');
    }
};
