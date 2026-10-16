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
        Schema::table('variants', function (Blueprint $table) {
            $table->boolean('is_recommended')->default(false)->after('is_active');
            $table->unsignedInteger('recommended_order')->nullable()->after('is_recommended');

            $table->index(['is_recommended', 'recommended_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->dropIndex(['is_recommended', 'recommended_order']);
            $table->dropColumn(['is_recommended', 'recommended_order']);
        });
    }
};
