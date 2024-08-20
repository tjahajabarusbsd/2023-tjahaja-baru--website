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
        Schema::table('consultations', function (Blueprint $table) {
            $table->string('cara_bayar')->nullable()->after('sales_code'); // Ganti 'existing_column' dengan nama kolom yang ada sebelum cara_bayar
            $table->string('dp')->nullable()->after('cara_bayar');
            $table->integer('tenor')->nullable()->after('dp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['cara_bayar', 'dp', 'tenor']);
        });
    }
};
