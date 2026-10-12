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
        Schema::create('feature_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique();          // 'qr_scan'
            $table->string('label');                      // 'Scan QR Code'
            $table->boolean('is_active')->default(true);
            $table->string('maintenance_message')->nullable();
            $table->timestamp('maintenance_until')->nullable();
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
        Schema::dropIfExists('feature_statuses');
    }
};
