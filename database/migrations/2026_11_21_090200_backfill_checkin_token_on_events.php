<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Event yang dibuat sebelum kolom checkin_token ada belum punya token.
     * Backfill supaya QR-nya langsung bisa dibuka tanpa perlu edit & simpan manual.
     *
     * @return void
     */
    public function up()
    {
        DB::table('events')
            ->whereNull('checkin_token')
            ->select('id')
            ->orderBy('id')
            ->chunkById(100, function ($events) {
                foreach ($events as $event) {
                    DB::table('events')
                        ->where('id', $event->id)
                        ->update(['checkin_token' => 'EVT-' . Str::uuid()->toString()]);
                }
            });
    }

    /**
     * Reverse the migrations.
     * Token sengaja tidak dihapus: QR yang sudah dicetak harus tetap valid.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
