<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameKodeSalesToKodeDealerInDealersTable extends Migration
{
    public function up()
    {
        $this->renameColumn('kode_sales', 'kode_dealer');
    }

    public function down()
    {
        $this->renameColumn('kode_dealer', 'kode_sales');
    }

    private function renameColumn($from, $to)
    {
        if (!Schema::hasTable('dealers')) {
            throw new \RuntimeException('The dealers table does not exist.');
        }

        $hasFrom = Schema::hasColumn('dealers', $from);
        $hasTo = Schema::hasColumn('dealers', $to);

        if ($hasFrom && !$hasTo) {
            Schema::table('dealers', function (Blueprint $table) use ($from, $to) {
                $table->renameColumn($from, $to);
            });

            return;
        }

        if (!$hasFrom && $hasTo) {
            return;
        }

        throw new \RuntimeException("Expected exactly one of the dealers columns '{$from}' or '{$to}'.");
    }
}
