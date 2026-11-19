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
        Schema::table('notifications', function (Blueprint $table) {
            // Menyimpan tahap pengingat servis: 60, 30, 15 (menit sebelum jam booking).
            // NULL untuk notifikasi lain.
            $table->string('reminder_stage', 20)->nullable()->after('category');

            // Mencegah pengingat yang sama terkirim dua kali (idempotent).
            $table->unique(
                ['source_type', 'source_id', 'category', 'reminder_stage'],
                'notifications_source_reminder_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropUnique('notifications_source_reminder_unique');
            $table->dropColumn('reminder_stage');
        });
    }
};
