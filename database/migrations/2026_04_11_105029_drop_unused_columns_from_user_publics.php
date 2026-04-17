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
        Schema::table('user_publics', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'facebook_id',
                'login_method',
                'temp_new_phone_number',
                'email_verified_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_publics', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('password');
            $table->string('facebook_id')->nullable()->after('google_id');
            $table->string('login_method')->nullable()->after('facebook_id');
            $table->string('temp_new_phone_number')->nullable()->after('login_method');
            $table->timestamp('email_verified_at')->nullable()->after('temp_new_phone_number');
        });
    }
};
