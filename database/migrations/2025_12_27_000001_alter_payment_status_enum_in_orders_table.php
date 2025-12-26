<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tambah nilai enum 'pending_verification'
        DB::statement("ALTER TABLE `orders` MODIFY `payment_status` ENUM('pending','paid','failed','pending_verification') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Pastikan tidak ada nilai yang tidak termasuk sebelum mengubah kembali
        DB::table('orders')->where('payment_status', 'pending_verification')->update(['payment_status' => 'pending']);
        DB::statement("ALTER TABLE `orders` MODIFY `payment_status` ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending'");
    }
};
