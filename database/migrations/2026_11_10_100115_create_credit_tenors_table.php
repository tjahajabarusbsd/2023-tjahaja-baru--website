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
        Schema::create('credit_tenors', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('months')->unique();
            // semua rate disimpan dalam PERSEN (15 = 15%)
            $table->decimal('flat_rate', 6, 2);            // bunga flat per tahun
            $table->decimal('life_insurance_rate', 6, 4);  // asuransi jiwa, % dari plafon
            $table->decimal('provision_percent', 6, 2)->default(0); // provisi, % dari (OTR - DP)
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('credit_tenors');
    }
};
