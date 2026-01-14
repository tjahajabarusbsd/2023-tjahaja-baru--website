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
        Schema::table('promos', function (Blueprint $table) {
            // checklist target
            $table->boolean('show_on_pc')->default(true)->after('image');
            $table->boolean('show_on_mobile')->default(true)->after('show_on_pc');

            // konten
            $table->text('description')->nullable()->after('uri');
            $table->text('terms_conditions')->nullable()->after('description');

            // Periode
            $table->dateTime('start_date')->nullable()->after('description');
            $table->dateTime('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropColumn([
                'show_on_pc',
                'show_on_mobile',
                'description',
                'terms_conditions',
                'start_date',
                'end_date',
            ]);
        });
    }
};
